<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
final class SprintfStringAndArgs
{
    /**
     * @var Expr[]
     */
    private $arrayItems = [];
    /**
     * @var String_
     */
    private $string;
    /**
     * @param Expr[] $arrayItems
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ $string, array $arrayItems)
    {
        $this->string = $string;
        $this->arrayItems = $arrayItems;
    }
    /**
     * @return Expr[]
     */
    public function getArrayItems() : array
    {
        return $this->arrayItems;
    }
    public function getStringValue() : string
    {
        return $this->string->value;
    }
}
