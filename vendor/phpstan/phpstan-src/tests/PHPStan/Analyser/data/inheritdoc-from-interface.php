<?php

namespace _PhpScoper88fe6e0ad041\InheritDocFromInterface;

class Foo extends \_PhpScoper88fe6e0ad041\InheritDocFromInterface\FooParent implements \_PhpScoper88fe6e0ad041\InheritDocFromInterface\FooInterface
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
