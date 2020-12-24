<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseAnd as AssignBitwiseAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseOr as AssignBitwiseOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseXor as AssignBitwiseXor;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Concat as AssignConcat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mod as AssignMod;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Pow as AssignPow;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\ShiftLeft as AssignShiftLeft;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\ShiftRight as AssignShiftRight;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseXor;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Div;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mod;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Pow;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\ShiftLeft;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\ShiftRight;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
final class AssignAndBinaryMap
{
    /**
     * @var string[]
     */
    private const BINARY_OP_TO_INVERSE_CLASSES = [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotEqual::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater::class];
    /**
     * @var class-string[]
     */
    private const ASSIGN_OP_TO_BINARY_OP_CLASSES = [\_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseOr::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseAnd::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseAnd::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\BitwiseXor::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseXor::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Plus::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Plus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Div::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Div::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mul::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mul::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Minus::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Concat::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Pow::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Pow::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Mod::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Mod::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\ShiftLeft::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\ShiftLeft::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\ShiftRight::class => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\ShiftRight::class];
    /**
     * @var string[]
     */
    private $binaryOpToAssignClasses = [];
    public function __construct()
    {
        $this->binaryOpToAssignClasses = \array_flip(self::ASSIGN_OP_TO_BINARY_OP_CLASSES);
    }
    public function getAlternative(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $nodeClass = \get_class($node);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp) {
            return self::ASSIGN_OP_TO_BINARY_OP_CLASSES[$nodeClass] ?? null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return $this->binaryOpToAssignClasses[$nodeClass] ?? null;
        }
        return null;
    }
    public function getInversed(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?string
    {
        $nodeClass = \get_class($binaryOp);
        return self::BINARY_OP_TO_INVERSE_CLASSES[$nodeClass] ?? null;
    }
}
