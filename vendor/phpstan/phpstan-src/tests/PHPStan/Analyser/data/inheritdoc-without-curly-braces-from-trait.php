<?php

namespace _PhpScopera143bcca66cb\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScopera143bcca66cb\InheritDocWithoutCurlyBracesFromTrait\FooInterface
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
