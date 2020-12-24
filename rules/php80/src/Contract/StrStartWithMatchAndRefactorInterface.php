<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Php80\ValueObject\StrStartsWith;
interface StrStartWithMatchAndRefactorInterface
{
    public function match(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\StrStartsWith;
    /**
     * @return FuncCall|BooleanNot|null
     */
    public function refactorStrStartsWith(\_PhpScoper0a6b37af0871\Rector\Php80\ValueObject\StrStartsWith $strStartsWith) : ?\_PhpScoper0a6b37af0871\PhpParser\Node;
}
