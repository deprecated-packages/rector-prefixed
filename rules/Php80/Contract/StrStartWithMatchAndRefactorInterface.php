<?php

declare (strict_types=1);
namespace Rector\Php80\Contract;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\FuncCall;
use Rector\Php80\ValueObject\StrStartsWith;
interface StrStartWithMatchAndRefactorInterface
{
    /**
     * @return \Rector\Php80\ValueObject\StrStartsWith|null
     * @param \PhpParser\Node\Expr\BinaryOp $binaryOp
     */
    public function match($binaryOp);
    /**
     * @return \PhpParser\Node|null
     * @param \Rector\Php80\ValueObject\StrStartsWith $strStartsWith
     */
    public function refactorStrStartsWith($strStartsWith);
}
