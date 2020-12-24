<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith;
final class StrposMatchAndRefactor extends \_PhpScoperb75b35f52b74\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScoperb75b35f52b74\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->left, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $strposFuncCall = $strStartsWith->getFuncCall();
        $strposFuncCall->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('str_starts_with');
        return $this->createStrStartsWith($strStartsWith);
    }
}
