<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_ $string, array $arrayItems)
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
