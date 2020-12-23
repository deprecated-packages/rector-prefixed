<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayItemsAndFluentClass;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayToFluentCall;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\FactoryMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\CakePHP\Tests\Rector\MethodCall\ArrayToFluentCallRector\ArrayToFluentCallRectorTest
 */
final class ArrayToFluentCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const ARRAYS_TO_FLUENT_CALLS = 'arrays_to_fluent_calls';
    /**
     * @var string
     */
    public const FACTORY_METHODS = 'factory_methods';
    /**
     * @var ArrayToFluentCall[]
     */
    private $arraysToFluentCalls = [];
    /**
     * @var FactoryMethod[]
     */
    private $factoryMethods = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Moves array options to fluent setter method calls.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, <<<'CODE_SAMPLE'
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
, [self::ARRAYS_TO_FLUENT_CALLS => [new \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayToFluentCall('ArticlesTable', ['foreignKey' => 'setForeignKey', 'propertyName' => 'setProperty'])]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $factoryMethod = $this->matchTypeAndMethodName($node);
        if ($factoryMethod === null) {
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
    public function configure(array $configuration) : void
    {
        $arraysToFluentCalls = $configuration[self::ARRAYS_TO_FLUENT_CALLS] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($arraysToFluentCalls, \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayToFluentCall::class);
        $this->arraysToFluentCalls = $arraysToFluentCalls;
        $factoryMethods = $configuration[self::FACTORY_METHODS] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($factoryMethods, \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\FactoryMethod::class);
        $this->factoryMethods = $factoryMethods;
    }
    private function matchTypeAndMethodName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\FactoryMethod
    {
        foreach ($this->factoryMethods as $factoryMethod) {
            if (!$this->isObjectType($methodCall->var, $factoryMethod->getType())) {
                continue;
            }
            if (!$this->isName($methodCall->name, $factoryMethod->getMethod())) {
                continue;
            }
            return $factoryMethod;
        }
        return null;
    }
    private function replaceArrayToFluentMethodCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, int $argumentPosition, \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayToFluentCall $arrayToFluentCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        if (\count((array) $methodCall->args) !== $argumentPosition) {
            return null;
        }
        $argumentValue = $methodCall->args[$argumentPosition - 1]->value;
        if (!$argumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            return null;
        }
        $arrayItemsAndFluentClass = $this->extractFluentMethods($argumentValue->items, $arrayToFluentCall->getArrayKeysToFluentCalls());
        if ($arrayItemsAndFluentClass->getArrayItems() !== []) {
            $argumentValue->items = $arrayItemsAndFluentClass->getArrayItems();
        } else {
            unset($methodCall->args[$argumentPosition - 1]);
        }
        if ($arrayItemsAndFluentClass->getFluentCalls() === []) {
            return null;
        }
        $node = $methodCall;
        foreach ($arrayItemsAndFluentClass->getFluentCalls() as $method => $expr) {
            $args = $this->createArgs([$expr]);
            $node = $this->createMethodCall($node, $method, $args);
        }
        return $node;
    }
    /**
     * @param array<ArrayItem|null> $originalArrayItems
     * @param array<string, string> $arrayMap
     */
    private function extractFluentMethods(array $originalArrayItems, array $arrayMap) : \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayItemsAndFluentClass
    {
        $newArrayItems = [];
        $fluentCalls = [];
        foreach ($originalArrayItems as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            /** @var ArrayItem $arrayItem */
            $key = $arrayItem->key;
            if ($key instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_ && isset($arrayMap[$key->value])) {
                /** @var string $methodName */
                $methodName = $arrayMap[$key->value];
                $fluentCalls[$methodName] = $arrayItem->value;
            } else {
                $newArrayItems[] = $arrayItem;
            }
        }
        return new \_PhpScoper0a2ac50786fa\Rector\CakePHP\ValueObject\ArrayItemsAndFluentClass($newArrayItems, $fluentCalls);
    }
}
