<?php

declare(strict_types=1);

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
     */
    public function match(BinaryOp $binaryOp);

    /**
     * @return \PhpParser\Node|null
     */
    public function refactorStrStartsWith(StrStartsWith $strStartsWith);
}
