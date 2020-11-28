<?php

namespace _PhpScoperabd03f0baf05\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\Foo
    {
    }
}
class WithFooAndBar
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    /** @var AnotherFoo */
    public $foo;
    /** @var Bar */
    public $bar;
    public function doFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScoperabd03f0baf05\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScoperabd03f0baf05\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScoperabd03f0baf05\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScoperabd03f0baf05\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScoperabd03f0baf05\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScoperabd03f0baf05\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScoperabd03f0baf05\UnionIntersection\WithFoo $foo, \_PhpScoperabd03f0baf05\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScoperabd03f0baf05\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScoperabd03f0baf05\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScoperabd03f0baf05\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
