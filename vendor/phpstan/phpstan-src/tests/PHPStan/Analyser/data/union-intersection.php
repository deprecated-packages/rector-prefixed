<?php

namespace _PhpScopera143bcca66cb\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScopera143bcca66cb\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScopera143bcca66cb\UnionIntersection\Foo
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
    public function doFoo() : \_PhpScopera143bcca66cb\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScopera143bcca66cb\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScopera143bcca66cb\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScopera143bcca66cb\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScopera143bcca66cb\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScopera143bcca66cb\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScopera143bcca66cb\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScopera143bcca66cb\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScopera143bcca66cb\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScopera143bcca66cb\UnionIntersection\WithFoo $foo, \_PhpScopera143bcca66cb\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScopera143bcca66cb\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScopera143bcca66cb\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScopera143bcca66cb\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
