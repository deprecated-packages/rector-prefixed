<?php

namespace _PhpScoper26e51eeacccf\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\Foo
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
    public function doFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScoper26e51eeacccf\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScoper26e51eeacccf\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScoper26e51eeacccf\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScoper26e51eeacccf\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScoper26e51eeacccf\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScoper26e51eeacccf\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScoper26e51eeacccf\UnionIntersection\WithFoo $foo, \_PhpScoper26e51eeacccf\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScoper26e51eeacccf\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScoper26e51eeacccf\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScoper26e51eeacccf\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
