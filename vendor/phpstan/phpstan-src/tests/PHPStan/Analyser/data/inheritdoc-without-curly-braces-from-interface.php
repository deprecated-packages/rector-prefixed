<?php

namespace _PhpScoper006a73f0e455\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \_PhpScoper006a73f0e455\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \_PhpScoper006a73f0e455\InheritDocWithoutCurlyBracesFromInterface\FooInterface
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
