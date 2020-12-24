<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch $constFetch)
    {
        $this->arrayDimFetch = $arrayDimFetch;
        $this->constFetch = $constFetch;
    }
    public function getArrayDimFetch() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch
    {
        return $this->arrayDimFetch;
    }
    public function getConstFetch() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch
    {
        return $this->constFetch;
    }
}
