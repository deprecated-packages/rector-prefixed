<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith;
final class StrncmpMatchAndRefactor extends \_PhpScoperb75b35f52b74\Rector\Php80\MatchAndRefactor\StrStartsWithMatchAndRefactor\AbstractMatchAndRefactor implements \_PhpScoperb75b35f52b74\Rector\Php80\Contract\StrStartWithMatchAndRefactorInterface
{
    /**
     * @var string
     */
    private const FUNCTION_NAME = 'strncmp';
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    public function match(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith
    {
        $isPositive = $binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
        if ($this->isFuncCallName($binaryOp->left, self::FUNCTION_NAME)) {
            return $this->createStrStartsWithValueObjectFromFuncCall($binaryOp->left, $isPositive);
        }
        if ($this->isFuncCallName($binaryOp->right, self::FUNCTION_NAME)) {
            return $this->createStrStartsWithValueObjectFromFuncCall($binaryOp->right, $isPositive);
        }
        return null;
    }
    public function refactorStrStartsWith(\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $strncmpFuncCall = $strStartsWith->getFuncCall();
        $needleExpr = $strStartsWith->getNeedleExpr();
        if (!$this->isFuncCallName($strncmpFuncCall->args[2]->value, 'strlen')) {
            return null;
        }
        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $strncmpFuncCall->args[2]->value;
        $strlenArgumentValue = $strlenFuncCall->args[0]->value;
        if (!$this->betterStandardPrinter->areNodesEqual($needleExpr, $strlenArgumentValue)) {
            return null;
        }
        return $this->createStrStartsWith($strStartsWith);
    }
}
