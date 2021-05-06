<?php

declare (strict_types=1);
namespace Rector\Core\ValueObject;

use PhpParser\Node\Expr;
use PhpParser\Node\Scalar\String_;
final class SprintfStringAndArgs
{
    /**
     * @var \PhpParser\Node\Scalar\String_
     */
    private $string;
    /**
     * @var mixed[]
     */
    private $arrayItems;
    /**
     * @param Expr[] $arrayItems
     */
    public function __construct(
        \PhpParser\Node\Scalar\String_ $string,
        /**
         * @var Expr[]
         */
        array $arrayItems
    )
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
