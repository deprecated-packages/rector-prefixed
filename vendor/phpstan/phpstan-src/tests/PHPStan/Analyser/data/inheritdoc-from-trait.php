<?php

namespace _PhpScoperabd03f0baf05\InheritDocFromTrait;

class Foo implements \_PhpScoperabd03f0baf05\InheritDocFromTrait\FooInterface
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
