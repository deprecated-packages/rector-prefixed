<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\EarlyReturn\NodeTransformer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
final class ConditionInverter
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function createInvertedCondition(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        // inverse condition
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            $inversedCondition = $this->binaryOpManipulator->invertCondition($expr);
            if ($inversedCondition === null || $inversedCondition instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($expr);
            }
            return $inversedCondition;
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
