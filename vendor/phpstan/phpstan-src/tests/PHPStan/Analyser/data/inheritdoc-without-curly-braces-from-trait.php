<?php

namespace _PhpScoperabd03f0baf05\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScoperabd03f0baf05\InheritDocWithoutCurlyBracesFromTrait\FooInterface
{
    use FooTrait;
}
trait FooTrait
{
    /**
     * @inheritdoc
     */
    public function doFoo($string)
    {
        die;
    }
}
interface FooInterface
{
    /**
     * @param string $string
     */
    public function doFoo($string);
}
