<?php

namespace _PhpScopera143bcca66cb\InheritDocFromTrait;

class Foo implements \_PhpScopera143bcca66cb\InheritDocFromTrait\FooInterface
{
    use FooTrait;
}
trait FooTrait
{
    /**
     * {@inheritdoc}
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
