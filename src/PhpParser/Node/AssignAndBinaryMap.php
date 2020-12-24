<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseAnd as AssignBitwiseAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseOr as AssignBitwiseOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseXor as AssignBitwiseXor;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Concat as AssignConcat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Div as AssignDiv;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus as AssignMinus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mod as AssignMod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mul as AssignMul;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus as AssignPlus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Pow as AssignPow;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\ShiftLeft as AssignShiftLeft;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\ShiftRight as AssignShiftRight;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseXor;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Div;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Plus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Pow;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\ShiftLeft;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\ShiftRight;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
final class AssignAndBinaryMap
{
    /**
     * @var string[]
     */
    private const BINARY_OP_TO_INVERSE_CLASSES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotEqual::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater::class];
    /**
     * @var class-string[]
     */
    private const ASSIGN_OP_TO_BINARY_OP_CLASSES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseOr::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseOr::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseAnd::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseAnd::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\BitwiseXor::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BitwiseXor::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Plus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Div::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Div::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mul::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mul::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Minus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Concat::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Pow::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Pow::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Mod::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Mod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\ShiftLeft::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\ShiftLeft::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\ShiftRight::class => \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\ShiftRight::class];
    /**
     * @var string[]
     */
    private $binaryOpToAssignClasses = [];
    public function __construct()
    {
        $this->binaryOpToAssignClasses = \array_flip(self::ASSIGN_OP_TO_BINARY_OP_CLASSES);
    }
    public function getAlternative(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $nodeClass = \get_class($node);
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp) {
            return self::ASSIGN_OP_TO_BINARY_OP_CLASSES[$nodeClass] ?? null;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
            return $this->binaryOpToAssignClasses[$nodeClass] ?? null;
        }
        return null;
    }
    public function getInversed(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?string
    {
        $nodeClass = \get_class($binaryOp);
        return self::BINARY_OP_TO_INVERSE_CLASSES[$nodeClass] ?? null;
    }
}
