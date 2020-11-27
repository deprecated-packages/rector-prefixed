<?php

namespace _PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromTrait;

class Foo implements \_PhpScoperbd5d0c5f7638\InheritDocWithoutCurlyBracesFromTrait\FooInterface
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
