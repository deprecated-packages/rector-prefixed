<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\NodeFinder\NextVariableUsageNodeFinder;
use _PhpScopere8e811afab72\Rector\DeadCode\NodeFinder\PreviousVariableAssignNodeFinder;
use _PhpScopere8e811afab72\Rector\DeadCode\SideEffect\SideEffectNodeDetector;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ScopeNestingComparator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Assign\RemoveUnusedAssignVariableRector\RemoveUnusedAssignVariableRectorTest
 */
final class RemoveUnusedAssignVariableRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var SideEffectNodeDetector
     */
    private $sideEffectNodeDetector;
    /**
     * @var PreviousVariableAssignNodeFinder
     */
    private $previousVariableAssignNodeFinder;
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    /**
     * @var NextVariableUsageNodeFinder
     */
    private $nextVariableUsageNodeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadCode\NodeFinder\NextVariableUsageNodeFinder $nextVariableUsageNodeFinder, \_PhpScopere8e811afab72\Rector\DeadCode\NodeFinder\PreviousVariableAssignNodeFinder $previousVariableAssignNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator, \_PhpScopere8e811afab72\Rector\DeadCode\SideEffect\SideEffectNodeDetector $sideEffectNodeDetector)
    {
        $this->sideEffectNodeDetector = $sideEffectNodeDetector;
        $this->previousVariableAssignNodeFinder = $previousVariableAssignNodeFinder;
        $this->scopeNestingComparator = $scopeNestingComparator;
        $this->nextVariableUsageNodeFinder = $nextVariableUsageNodeFinder;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class];
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove assigned unused variable', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = $this->process();
    }

    public function process()
    {
        // something going on
        return 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->process();
    }

    public function process()
    {
        // something going on
        return 5;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkipAssign($node)) {
            return null;
        }
        if ($this->isVariableTypeInScope($node) && !$this->isPreviousVariablePartOfOverridingAssign($node)) {
            return null;
        }
        // is scalar assign? remove whole
        if (!$this->sideEffectNodeDetector->detect($node->expr)) {
            $this->removeNode($node);
            return null;
        }
        return $node->expr;
    }
    private function shouldSkipAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \true;
        }
        // unable to resolve name
        $variableName = $this->getName($assign->var);
        if ($variableName === null) {
            return \true;
        }
        if ($this->isNestedAssign($assign)) {
            return \true;
        }
        $nextUsedVariable = $this->nextVariableUsageNodeFinder->find($assign);
        return $nextUsedVariable !== null;
    }
    private function isVariableTypeInScope(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        /** @var Scope|null $scope */
        $scope = $assign->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScopere8e811afab72\PHPStan\Analyser\Scope) {
            return \false;
        }
        /** @var string $variableName */
        $variableName = $this->getName($assign->var);
        return !$scope->hasVariableType($variableName)->no();
    }
    private function isPreviousVariablePartOfOverridingAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        // is previous variable node as part of assign?
        $previousVariableAssign = $this->previousVariableAssignNodeFinder->find($assign);
        if ($previousVariableAssign === null) {
            return \false;
        }
        return $this->scopeNestingComparator->areScopeNestingEqual($assign, $previousVariableAssign);
    }
    /**
     * Nested assign, e.g "$oldValues = <$values> = 5;"
     */
    private function isNestedAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        $parentNode = $assign->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        return $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
    }
}
