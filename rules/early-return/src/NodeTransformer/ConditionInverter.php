<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\EarlyReturn\NodeTransformer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
final class ConditionInverter
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function createInvertedCondition(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        // inverse condition
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            $inversedCondition = $this->binaryOpManipulator->invertCondition($expr);
            if ($inversedCondition === null || $inversedCondition instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($expr);
            }
            return $inversedCondition;
        }
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            return $expr->expr;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($expr);
    }
}
