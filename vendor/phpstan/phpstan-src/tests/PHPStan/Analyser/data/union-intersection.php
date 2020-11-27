<?php

namespace _PhpScoper88fe6e0ad041\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\Foo
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
    public function doFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScoper88fe6e0ad041\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScoper88fe6e0ad041\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScoper88fe6e0ad041\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScoper88fe6e0ad041\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScoper88fe6e0ad041\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScoper88fe6e0ad041\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScoper88fe6e0ad041\UnionIntersection\WithFoo $foo, \_PhpScoper88fe6e0ad041\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScoper88fe6e0ad041\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScoper88fe6e0ad041\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScoper88fe6e0ad041\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
