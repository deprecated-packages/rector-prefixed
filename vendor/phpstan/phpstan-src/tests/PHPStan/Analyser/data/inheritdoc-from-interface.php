<?php

namespace _PhpScopera143bcca66cb\InheritDocFromInterface;

class Foo extends \_PhpScopera143bcca66cb\InheritDocFromInterface\FooParent implements \_PhpScopera143bcca66cb\InheritDocFromInterface\FooInterface
{
    /**
     * {@inheritdoc}
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
