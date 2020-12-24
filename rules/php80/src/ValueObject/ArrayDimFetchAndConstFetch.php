<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch $constFetch)
    {
        $this->arrayDimFetch = $arrayDimFetch;
        $this->constFetch = $constFetch;
    }
    public function getArrayDimFetch() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch
    {
        return $this->arrayDimFetch;
    }
    public function getConstFetch() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch
    {
        return $this->constFetch;
    }
}
