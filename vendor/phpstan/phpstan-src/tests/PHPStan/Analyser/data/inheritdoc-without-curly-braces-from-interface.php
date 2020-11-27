<?php

namespace _PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \_PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \_PhpScoper88fe6e0ad041\InheritDocWithoutCurlyBracesFromInterface\FooInterface
{
    /**
     * @inheritdoc
     */
    public function doFoo($string)
    {
        die;
    }
}
abstract class FooParent
{
}
interface FooInterface
{
    /**
     * @param string $string
     */
    public function doFoo($string);
}
