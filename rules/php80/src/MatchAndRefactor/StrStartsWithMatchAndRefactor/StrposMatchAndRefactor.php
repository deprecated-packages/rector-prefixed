<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith;
final class StrposMatchAndRefactor extends \_PhpScoper0a2ac50786fa\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScoper0a2ac50786fa\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->left, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $strposFuncCall = $strStartsWith->getFuncCall();
        $strposFuncCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('str_starts_with');
        return $this->createStrStartsWith($strStartsWith);
    }
}
