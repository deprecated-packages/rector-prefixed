<?php

namespace _PhpScoper26e51eeacccf\ArrayAccesable;

class Foo implements \ArrayAccess
{
    public function __construct()
    {
        die;
    }
    /**
     * @return string[]
     */
    public function returnArrayOfStrings() : array
    {
    }
    /**
     * @return mixed
     */
    public function returnMixed()
    {
    }
    /**
     * @return self|int[]
     */
    public function returnSelfWithIterableInt() : self
    {
    }
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : int
    {
    }
    public function offsetSet($offset, $value)
    {
    }
    public function offsetUnset($offset)
    {
    }
}
