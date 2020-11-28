<?php

namespace _PhpScoperabd03f0baf05\InheritDocWithoutCurlyBracesFromInterface;

class Foo extends \_PhpScoperabd03f0baf05\InheritDocWithoutCurlyBracesFromInterface\FooParent implements \_PhpScoperabd03f0baf05\InheritDocWithoutCurlyBracesFromInterface\FooInterface
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
