<?php

namespace _PhpScoper26e51eeacccf\InheritDocFromTrait;

class Foo implements \_PhpScoper26e51eeacccf\InheritDocFromTrait\FooInterface
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
