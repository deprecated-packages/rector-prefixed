<?php

namespace _PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromTrait\FooInterface
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
