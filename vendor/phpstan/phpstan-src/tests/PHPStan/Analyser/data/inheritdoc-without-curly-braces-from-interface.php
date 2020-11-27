<?php

namespace _PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \_PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \_PhpScoper26e51eeacccf\InheritDocWithoutCurlyBracesFromInterface\FooInterface
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
