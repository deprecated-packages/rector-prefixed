<?php

namespace _PhpScoper26e51eeacccf\InheritDocFromInterface;

class Foo extends \_PhpScoper26e51eeacccf\InheritDocFromInterface\FooParent implements \_PhpScoper26e51eeacccf\InheritDocFromInterface\FooInterface
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
