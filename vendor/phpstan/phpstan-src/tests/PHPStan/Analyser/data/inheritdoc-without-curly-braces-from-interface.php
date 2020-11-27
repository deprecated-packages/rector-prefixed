<?php

namespace _PhpScopera143bcca66cb\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \_PhpScopera143bcca66cb\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \_PhpScopera143bcca66cb\InheritDocWithoutCurlyBracesFromInterface\FooInterface
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
