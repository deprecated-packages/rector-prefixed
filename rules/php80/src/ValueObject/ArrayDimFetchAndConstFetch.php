<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch $constFetch)
    {
        $this->arrayDimFetch = $arrayDimFetch;
        $this->constFetch = $constFetch;
    }
    public function getArrayDimFetch() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch
    {
        return $this->arrayDimFetch;
    }
    public function getConstFetch() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch
    {
        return $this->constFetch;
    }
}
