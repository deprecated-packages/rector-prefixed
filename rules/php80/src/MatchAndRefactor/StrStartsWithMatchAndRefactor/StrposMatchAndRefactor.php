<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith;
final class StrposMatchAndRefactor extends \_PhpScoper2a4e7ab1ecbc\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScoper2a4e7ab1ecbc\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->left, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $strposFuncCall = $strStartsWith->getFuncCall();
        $strposFuncCall->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('str_starts_with');
        return $this->createStrStartsWith($strStartsWith);
    }
}
