<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php80\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
final class ArrayDimFetchAndConstFetch
{
    /**
     * @var ArrayDimFetch
     */
    private $arrayDimFetch;
    /**
     * @var ConstFetch
     */
    private $constFetch;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch $constFetch)
    {
        $this->arrayDimFetch = $arrayDimFetch;
        $this->constFetch = $constFetch;
    }
    public function getArrayDimFetch() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch
    {
        return $this->arrayDimFetch;
    }
    public function getConstFetch() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch
    {
        return $this->constFetch;
    }
}
