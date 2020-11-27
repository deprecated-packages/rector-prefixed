<?php

declare (strict_types=1);
namespace Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use Rector\Php80\ValueObject\StrStartsWith;
final class StrposMatchAndRefactor extends \Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->right, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->left;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, 'strpos')) {
            if (!$this->valueResolver->isValue($binaryOp->left, 0)) {
                return null;
            }
            /** @var FuncCall $funcCall */
            $funcCall = $binaryOp->right;
            $haystack = $funcCall->args[0]->value;
            $needle = $funcCall->args[1]->value;
            return new \Rector\Php80\ValueObject\StrStartsWith($funcCall, $haystack, $needle, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\PhpParser\Node
    {
        $strposFuncCall = $strStartsWith->getFuncCall();
        $strposFuncCall->name = new \PhpParser\Node\Name('str_starts_with');
        return $this->createStrStartsWith($strStartsWith);
    }
}
