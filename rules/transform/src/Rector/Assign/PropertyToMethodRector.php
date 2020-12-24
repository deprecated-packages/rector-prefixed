<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\Assign\PropertyToMethodRector\PropertyToMethodRectorTest
 */
final class PropertyToMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PROPERTIES_TO_METHOD_CALLS = 'properties_to_method_calls';
    /**
     * @var PropertyToMethod[]
     */
    private $propertiesToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $firstConfiguration = [self::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('SomeObject', 'property', 'getProperty', 'setProperty')]];
        $secondConfiguration = [self::PROPERTIES_TO_METHOD_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod('SomeObject', 'property', 'getConfig', null, ['someArg'])]];
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces properties assign calls be defined methods.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$result = $object->property;
$object->property = $value;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$result = $object->getProperty();
$object->setProperty($value);
CODE_SAMPLE
, $firstConfiguration), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return $this->processSetter($node);
        }
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return $this->processGetter($node);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $propertiesToMethodCalls = $configuration[self::PROPERTIES_TO_METHOD_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($propertiesToMethodCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod::class);
        $this->propertiesToMethodCalls = $propertiesToMethodCalls;
    }
    private function processSetter(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        $propertyToMethodCall = $this->matchPropertyFetchCandidate($propertyFetchNode);
        if ($propertyToMethodCall === null) {
            return null;
        }
        if ($propertyToMethodCall->getNewSetMethod() === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $args = $this->createArgs([$assign->expr]);
        /** @var Variable $variable */
        $variable = $propertyFetchNode->var;
        return $this->createMethodCall($variable, $propertyToMethodCall->getNewSetMethod(), $args);
    }
    private function processGetter(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
    private function matchPropertyFetchCandidate(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyToMethod
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
