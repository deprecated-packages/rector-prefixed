<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyAssignToMethodCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\Assign\PropertyAssignToMethodCallRector\PropertyAssignToMethodCallRectorTest
 */
final class PropertyAssignToMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PROPERTY_ASSIGNS_TO_METHODS_CALLS = 'property_assigns_to_methods_calls';
    /**
     * @var PropertyAssignToMethodCall[]
     */
    private $propertyAssignsToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns property assign of specific type and property name to method call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->oldProperty = false;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeClass;
$someObject->newMethodCall(false);
CODE_SAMPLE
, [self::PROPERTY_ASSIGNS_TO_METHODS_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyAssignToMethodCall('SomeClass', 'oldProperty', 'newMethodCall')]])]);
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
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return null;
        }
        $propertyFetchNode = $node->var;
        /** @var Variable $propertyNode */
        $propertyNode = $propertyFetchNode->var;
        foreach ($this->propertyAssignsToMethodCalls as $propertyAssignToMethodCall) {
            if (!$this->isObjectType($propertyFetchNode->var, $propertyAssignToMethodCall->getClass())) {
                continue;
            }
            if (!$this->isName($propertyFetchNode, $propertyAssignToMethodCall->getOldPropertyName())) {
                continue;
            }
            return $this->createMethodCall($propertyNode, $propertyAssignToMethodCall->getNewMethodName(), [$node->expr]);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $propertyAssignsToMethodCalls = $configuration[self::PROPERTY_ASSIGNS_TO_METHODS_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($propertyAssignsToMethodCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\PropertyAssignToMethodCall::class);
        $this->propertyAssignsToMethodCalls = $propertyAssignsToMethodCalls;
    }
}
