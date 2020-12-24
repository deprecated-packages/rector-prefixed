<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\PropertyToMethodRectorTest
 */
final class PropertyToMethodRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PROPERTIES_TO_METHOD_CALLS = 'properties_to_method_calls';
    /**
     * @var PropertyToMethod[]
     */
    private $propertiesToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $firstConfiguration = [self::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('SomeObject', 'property', 'getProperty', 'setProperty')]];
        $secondConfiguration = [self::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod('SomeObject', 'property', 'getConfig', null, ['someArg'])]];
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces properties assign calls be defined methods.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$result = $object->property;
$object->property = $value;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$result = $object->getProperty();
$object->setProperty($value);
CODE_SAMPLE
, $firstConfiguration), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$result = $object->property;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$result = $object->getProperty('someArg');
CODE_SAMPLE
, $secondConfiguration)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return $this->processSetter($node);
        }
        if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return $this->processGetter($node);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $propertiesToMethodCalls = $configuration[self::PROPERTIES_TO_METHOD_CALLS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($propertiesToMethodCalls, \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod::class);
        $this->propertiesToMethodCalls = $propertiesToMethodCalls;
    }
    private function processSetter(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        $propertyToMethodCall = $this->matchPropertyFetchCandidate($propertyFetchNode);
        if ($propertyToMethodCall === null) {
            return null;
        }
        if ($propertyToMethodCall->getNewSetMethod() === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $args = $this->createArgs([$assign->expr]);
        /** @var Variable $variable */
        $variable = $propertyFetchNode->var;
        return $this->createMethodCall($variable, $propertyToMethodCall->getNewSetMethod(), $args);
    }
    private function processGetter(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->expr;
        $propertyToMethodCall = $this->matchPropertyFetchCandidate($propertyFetchNode);
        if ($propertyToMethodCall === null) {
            return null;
        }
        // simple method name
        if ($propertyToMethodCall->getNewGetMethod() !== '') {
            $assign->expr = $this->createMethodCall($propertyFetchNode->var, $propertyToMethodCall->getNewGetMethod());
            if ($propertyToMethodCall->getNewGetArguments() !== []) {
                $args = $this->createArgs($propertyToMethodCall->getNewGetArguments());
                $assign->expr->args = $args;
            }
            return $assign;
        }
        return $assign;
    }
    private function matchPropertyFetchCandidate(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\PropertyToMethod
    {
        foreach ($this->propertiesToMethodCalls as $propertyToMethodCall) {
            if (!$this->isObjectType($propertyFetch->var, $propertyToMethodCall->getOldType())) {
                continue;
            }
            if (!$this->isName($propertyFetch, $propertyToMethodCall->getOldProperty())) {
                continue;
            }
            return $propertyToMethodCall;
        }
        return null;
    }
}
