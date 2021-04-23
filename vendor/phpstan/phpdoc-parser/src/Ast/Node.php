<?php

declare (strict_types=1);
namespace PHPStan\PhpDocParser\Ast;

interface Node
{
    public function __toString() : string;
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setAttribute($key, $value);
    /**
     * @param string $key
     */
    public function hasAttribute($key) : bool;
    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key);
}
