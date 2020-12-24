<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith;
interface StrStartWithMatchAndRefactorInterface
{
    public function match(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith;
    /**
     * @return FuncCall|BooleanNot|null
     */
    public function refactorStrStartsWith(\_PhpScoperb75b35f52b74\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoperb75b35f52b74\PhpParser\Node;
}
