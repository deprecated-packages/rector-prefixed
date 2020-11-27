<?php

namespace _PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromTrait\FooInterface
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
