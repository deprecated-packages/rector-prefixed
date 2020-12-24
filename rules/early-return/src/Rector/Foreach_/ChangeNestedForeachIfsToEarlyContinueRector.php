<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\EarlyReturn\Rector\Foreach_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\EarlyReturn\NodeTransformer\ConditionInverter;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector\ChangeNestedForeachIfsToEarlyContinueRectorTest
 */
final class ChangeNestedForeachIfsToEarlyContinueRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var IfManipulator
     */
    private $ifManipulator;
    /**
     * @var ConditionInverter
     */
    private $conditionInverter;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\EarlyReturn\NodeTransformer\ConditionInverter $conditionInverter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\IfManipulator $ifManipulator)
    {
        $this->ifManipulator = $ifManipulator;
        $this->conditionInverter = $conditionInverter;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nested ifs to foreach with continue', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function processNestedIfsWithNonBreaking(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_ $foreach, array $nestedIfsWithOnlyReturn) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_
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
    private function addInvertedIfStmtWithContinue(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $nestedIfWithOnlyReturn, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        $invertedCondition = $this->conditionInverter->createInvertedCondition($nestedIfWithOnlyReturn->cond);
        // special case
        if ($invertedCondition instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot && $invertedCondition->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
            $leftExpr = $this->negateOrDeNegate($invertedCondition->expr->left);
            $if = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_($leftExpr);
            $if->stmts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_();
            $foreach->stmts[] = $if;
            $rightExpr = $this->negateOrDeNegate($invertedCondition->expr->right);
            $if = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_($rightExpr);
            $if->stmts[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_();
            $foreach->stmts[] = $if;
            return;
        }
        // should skip for weak inversion
        if ($this->isBooleanOrWithWeakComparison($nestedIfWithOnlyReturn->cond)) {
            $foreach->stmts[] = $nestedIfWithOnlyReturn;
            return;
        }
        $nestedIfWithOnlyReturn->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
        $nestedIfWithOnlyReturn->cond = $invertedCondition;
        $nestedIfWithOnlyReturn->stmts = [new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_()];
        $foreach->stmts[] = $nestedIfWithOnlyReturn;
    }
    /**
     * Matches:
     * $a == 1 || $b == 1
     *
     * Skips:
     * $a === 1 || $b === 2
     */
    private function isBooleanOrWithWeakComparison(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanOr) {
            return \false;
        }
        if ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal) {
            return \true;
        }
        if ($expr->left instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual) {
            return \true;
        }
        if ($expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Equal) {
            return \true;
        }
        return $expr->right instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotEqual;
    }
    private function negateOrDeNegate(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
