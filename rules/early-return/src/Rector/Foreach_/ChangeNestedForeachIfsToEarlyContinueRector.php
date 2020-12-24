<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\EarlyReturn\Rector\Foreach_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\EarlyReturn\NodeTransformer\ConditionInverter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector\ChangeNestedForeachIfsToEarlyContinueRectorTest
 */
final class ChangeNestedForeachIfsToEarlyContinueRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ConditionInverter
     */
    private $conditionInverter;
    public function __construct(\_PhpScopere8e811afab72\Rector\EarlyReturn\NodeTransformer\ConditionInverter $conditionInverter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->conditionInverter = $conditionInverter;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nested ifs to foreach with continue', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];

        foreach ($values as $value) {
            if ($value === 5) {
                if ($value2 === 10) {
                    $items[] = 'maybe';
                }
            }
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];

        foreach ($values as $value) {
            if ($value !== 5) {
                continue;
            }
            if ($value2 !== 10) {
                continue;
            }

            $items[] = 'maybe';
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $nestedIfsWithOnlyNonReturn = $this->ifManipulator->collectNestedIfsWithNonBreaking($node);
        if (\count($nestedIfsWithOnlyNonReturn) < 2) {
            return null;
        }
        return $this->processNestedIfsWithNonBreaking($node, $nestedIfsWithOnlyNonReturn);
    }
    /**
     * @param If_[] $nestedIfsWithOnlyReturn
     */
    private function processNestedIfsWithNonBreaking(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach, array $nestedIfsWithOnlyReturn) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_
    {
        // add nested if openly after this
        $nestedIfsWithOnlyReturnCount = \count($nestedIfsWithOnlyReturn);
        // clear
        $foreach->stmts = [];
        foreach ($nestedIfsWithOnlyReturn as $key => $nestedIfWithOnlyReturn) {
            // last item → the return node
            if ($nestedIfsWithOnlyReturnCount === $key + 1) {
                $finalReturn = clone $nestedIfWithOnlyReturn;
                $this->addInvertedIfStmtWithContinue($nestedIfWithOnlyReturn, $foreach);
                // should skip for weak inversion
                if ($this->isBooleanOrWithWeakComparison($nestedIfWithOnlyReturn->cond)) {
                    continue;
                }
                $foreach->stmts = \array_merge($foreach->stmts, $finalReturn->stmts);
            } else {
                $this->addInvertedIfStmtWithContinue($nestedIfWithOnlyReturn, $foreach);
            }
        }
        return $foreach;
    }
    private function addInvertedIfStmtWithContinue(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_ $nestedIfWithOnlyReturn, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        $invertedCondition = $this->conditionInverter->createInvertedCondition($nestedIfWithOnlyReturn->cond);
        // special case
        if ($invertedCondition instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot && $invertedCondition->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $leftExpr = $this->negateOrDeNegate($invertedCondition->expr->left);
            $if = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_($leftExpr);
            $if->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_();
            $foreach->stmts[] = $if;
            $rightExpr = $this->negateOrDeNegate($invertedCondition->expr->right);
            $if = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_($rightExpr);
            $if->stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_();
            $foreach->stmts[] = $if;
            return;
        }
        // should skip for weak inversion
        if ($this->isBooleanOrWithWeakComparison($nestedIfWithOnlyReturn->cond)) {
            $foreach->stmts[] = $nestedIfWithOnlyReturn;
            return;
        }
        $nestedIfWithOnlyReturn->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        $nestedIfWithOnlyReturn->cond = $invertedCondition;
        $nestedIfWithOnlyReturn->stmts = [new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_()];
        $foreach->stmts[] = $nestedIfWithOnlyReturn;
    }
    /**
     * Matches:
     * $a == 1 || $b == 1
     *
     * Skips:
     * $a === 1 || $b === 2
     */
    private function isBooleanOrWithWeakComparison(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \false;
        }
        if ($expr->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal) {
            return \true;
        }
        if ($expr->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return \true;
        }
        if ($expr->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal) {
            return \true;
        }
        return $expr->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual;
    }
    private function negateOrDeNegate(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
