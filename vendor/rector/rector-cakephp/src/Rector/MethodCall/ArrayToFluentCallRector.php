<?php

declare(strict_types=1);

namespace Rector\CakePHP\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\String_;
use Rector\CakePHP\ValueObject\ArrayItemsAndFluentClass;
use Rector\CakePHP\ValueObject\ArrayToFluentCall;
use Rector\CakePHP\ValueObject\FactoryMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @see \aRector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\ArrayToFluentCallRectorTest
 */
final class ArrayToFluentCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string
     */
    const ARRAYS_TO_FLUENT_CALLS = 'arrays_to_fluent_calls';

    /**
     * @var string
     */
    const FACTORY_METHODS = 'factory_methods';

    /**
     * @var ArrayToFluentCall[]
     */
    private $arraysToFluentCalls = [];

    /**
     * @var FactoryMethod[]
     */
    private $factoryMethods = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Moves array options to fluent setter method calls.', [
            new ConfiguredCodeSample(
                <<<'CODE_SAMPLE'
use Cake\ORM\Table;

final class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Authors', [
            'foreignKey' => 'author_id',
            'propertyName' => 'person'
        ]);
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
use Cake\ORM\Table;

final class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Authors')
            ->setForeignKey('author_id')
            ->setProperty('person');
    }
}
CODE_SAMPLE
                , [
                    self::ARRAYS_TO_FLUENT_CALLS => [
                        new ArrayToFluentCall('ArticlesTable', [
                            'foreignKey' => 'setForeignKey',
                            'propertyName' => 'setProperty',
                        ]),
                    ],
                ]
            ),
        ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    /**
     * @param MethodCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        $factoryMethod = $this->matchTypeAndMethodName($node);
        if (! $factoryMethod instanceof FactoryMethod) {
            return null;
        }

        foreach ($this->arraysToFluentCalls as $arraysToFluentCall) {
            if ($arraysToFluentCall->getClass() !== $factoryMethod->getNewClass()) {
                continue;
            }

            return $this->replaceArrayToFluentMethodCalls($node, $factoryMethod->getPosition(), $arraysToFluentCall);
        }

        return null;
    }

    /**
     * @return void
     */
    public function configure(array $configuration)
    {
        $arraysToFluentCalls = $configuration[self::ARRAYS_TO_FLUENT_CALLS] ?? [];
        Assert::allIsInstanceOf($arraysToFluentCalls, ArrayToFluentCall::class);
        $this->arraysToFluentCalls = $arraysToFluentCalls;

        $factoryMethods = $configuration[self::FACTORY_METHODS] ?? [];
        Assert::allIsInstanceOf($factoryMethods, FactoryMethod::class);
        $this->factoryMethods = $factoryMethods;
    }

    /**
     * @return \Rector\CakePHP\ValueObject\FactoryMethod|null
     */
    private function matchTypeAndMethodName(MethodCall $methodCall)
    {
        foreach ($this->factoryMethods as $factoryMethod) {
            if (! $this->isObjectType($methodCall->var, $factoryMethod->getObjectType())) {
                continue;
            }

            if (! $this->isName($methodCall->name, $factoryMethod->getMethod())) {
                continue;
            }

            return $factoryMethod;
        }

        return null;
    }

    /**
     * @return \PhpParser\Node\Expr\MethodCall|null
     */
    private function replaceArrayToFluentMethodCalls(
        MethodCall $methodCall,
        int $argumentPosition,
        ArrayToFluentCall $arrayToFluentCall
    ) {
        if (count($methodCall->args) !== $argumentPosition) {
            return null;
        }

        $argumentValue = $methodCall->args[$argumentPosition - 1]->value;
        if (! $argumentValue instanceof Array_) {
            return null;
        }

        $arrayItemsAndFluentClass = $this->extractFluentMethods(
            $argumentValue->items,
            $arrayToFluentCall->getArrayKeysToFluentCalls()
        );

        if ($arrayItemsAndFluentClass->getArrayItems() !== []) {
            $argumentValue->items = $arrayItemsAndFluentClass->getArrayItems();
        } else {
            $positionToRemove = $argumentPosition - 1;
            $this->nodeRemover->removeArg($methodCall, $positionToRemove);
        }

        if ($arrayItemsAndFluentClass->getFluentCalls() === []) {
            return null;
        }

        $node = $methodCall;

        foreach ($arrayItemsAndFluentClass->getFluentCalls() as $method => $expr) {
            $args = $this->nodeFactory->createArgs([$expr]);
            $node = $this->nodeFactory->createMethodCall($node, $method, $args);
        }

        return $node;
    }

    /**
     * @param array<ArrayItem|null> $originalArrayItems
     * @param array<string, string> $arrayMap
     */
    private function extractFluentMethods(array $originalArrayItems, array $arrayMap): ArrayItemsAndFluentClass
    {
        $newArrayItems = [];
        $fluentCalls = [];

        foreach ($originalArrayItems as $originalArrayItem) {
            if ($originalArrayItem === null) {
                continue;
            }

            $key = $originalArrayItem->key;

            if ($key instanceof String_ && isset($arrayMap[$key->value])) {
                /** @var string $methodName */
                $methodName = $arrayMap[$key->value];
                $fluentCalls[$methodName] = $originalArrayItem->value;
            } else {
                $newArrayItems[] = $originalArrayItem;
            }
        }

        return new ArrayItemsAndFluentClass($newArrayItems, $fluentCalls);
    }
}
