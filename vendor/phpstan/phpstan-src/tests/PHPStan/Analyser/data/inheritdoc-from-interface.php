<?php

namespace _PhpScoperabd03f0baf05\InheritDocFromInterface;

class Foo extends \_PhpScoperabd03f0baf05\InheritDocFromInterface\FooParent implements \_PhpScoperabd03f0baf05\InheritDocFromInterface\FooInterface
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
