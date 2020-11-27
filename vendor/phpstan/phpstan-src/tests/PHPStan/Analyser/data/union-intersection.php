<?php

namespace _PhpScoper006a73f0e455\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScoper006a73f0e455\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScoper006a73f0e455\UnionIntersection\Foo
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
    public function doFoo() : \_PhpScoper006a73f0e455\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScoper006a73f0e455\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScoper006a73f0e455\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScoper006a73f0e455\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScoper006a73f0e455\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScoper006a73f0e455\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScoper006a73f0e455\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScoper006a73f0e455\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScoper006a73f0e455\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScoper006a73f0e455\UnionIntersection\WithFoo $foo, \_PhpScoper006a73f0e455\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScoper006a73f0e455\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScoper006a73f0e455\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScoper006a73f0e455\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
