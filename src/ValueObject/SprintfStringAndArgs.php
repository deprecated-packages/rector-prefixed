<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_ $string, array $arrayItems)
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
