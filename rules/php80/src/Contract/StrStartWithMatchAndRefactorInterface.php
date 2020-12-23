<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith;
interface StrStartWithMatchAndRefactorInterface
{
    public function match(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith;
    /**
     * @return FuncCall|BooleanNot|null
     */
    public function refactorStrStartsWith(\_PhpScoper0a2ac50786fa\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node;
}
