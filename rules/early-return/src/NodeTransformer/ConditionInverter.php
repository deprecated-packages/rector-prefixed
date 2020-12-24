<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\EarlyReturn\NodeTransformer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
final class ConditionInverter
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function createInvertedCondition(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        // inverse condition
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            $inversedCondition = $this->binaryOpManipulator->invertCondition($expr);
            if ($inversedCondition === null || $inversedCondition instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($expr);
            }
            return $inversedCondition;
        }
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
