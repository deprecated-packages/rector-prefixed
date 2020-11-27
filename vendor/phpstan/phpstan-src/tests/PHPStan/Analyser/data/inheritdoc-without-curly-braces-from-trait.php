<?php

namespace _PhpScoper006a73f0e455\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScoper006a73f0e455\InheritDocWithoutCurlyBracesFromTrait\FooInterface
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
