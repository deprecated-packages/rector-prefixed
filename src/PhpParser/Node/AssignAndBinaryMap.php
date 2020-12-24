<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseAnd as AssignBitwiseAnd;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseOr as AssignBitwiseOr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseXor as AssignBitwiseXor;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Concat as AssignConcat;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Mod as AssignMod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Pow as AssignPow;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\ShiftLeft as AssignShiftLeft;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\ShiftRight as AssignShiftRight;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseXor;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Div;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Mod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Pow;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\ShiftLeft;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\ShiftRight;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
final class AssignAndBinaryMap
{
    /**
     * @var string[]
     */
    private const BINARY_OP_TO_INVERSE_CLASSES = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Equal::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotEqual::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotEqual::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Equal::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Greater::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Smaller::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Smaller::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Greater::class];
    /**
     * @var class-string[]
     */
    private const ASSIGN_OP_TO_BINARY_OP_CLASSES = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseOr::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseOr::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseAnd::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseAnd::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\BitwiseXor::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\BitwiseXor::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Plus::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Plus::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Div::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Div::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Mul::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Mul::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Minus::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Minus::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Concat::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Pow::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Pow::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\Mod::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Mod::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\ShiftLeft::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\ShiftLeft::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp\ShiftRight::class => \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\ShiftRight::class];
    /**
     * @var string[]
     */
    private $binaryOpToAssignClasses = [];
    public function __construct()
    {
        $this->binaryOpToAssignClasses = \array_flip(self::ASSIGN_OP_TO_BINARY_OP_CLASSES);
    }
    public function getAlternative(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        $nodeClass = \get_class($node);
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignOp) {
            return self::ASSIGN_OP_TO_BINARY_OP_CLASSES[$nodeClass] ?? null;
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp) {
            return $this->binaryOpToAssignClasses[$nodeClass] ?? null;
        }
        return null;
    }
    public function getInversed(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?string
    {
        $nodeClass = \get_class($binaryOp);
        return self::BINARY_OP_TO_INVERSE_CLASSES[$nodeClass] ?? null;
    }
}
