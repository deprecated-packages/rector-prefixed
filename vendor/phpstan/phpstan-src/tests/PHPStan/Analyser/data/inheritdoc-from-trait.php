<?php

namespace _PhpScoper88fe6e0ad041\InheritDocFromTrait;

class Foo implements \_PhpScoper88fe6e0ad041\InheritDocFromTrait\FooInterface
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
