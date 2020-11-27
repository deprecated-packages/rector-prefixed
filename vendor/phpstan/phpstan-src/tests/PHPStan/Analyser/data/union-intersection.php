<?php

namespace _PhpScoperbd5d0c5f7638\UnionIntersection;

class WithFoo
{
    const FOO_CONSTANT = 1;
    /** @var Foo */
    public $foo;
    public function doFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Foo
    {
    }
    public static function doStaticFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Foo
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
    public function doFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\AnotherFoo
    {
    }
    public static function doStaticFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\AnotherFoo
    {
    }
    public function doBar() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Bar
    {
    }
    public static function doStaticBar() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Bar
    {
    }
}
interface WithFooAndBarInterface
{
    const FOO_CONSTANT = 1;
    const BAR_CONSTANT = 1;
    public function doFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\AnotherFoo;
    public static function doStaticFoo() : \_PhpScoperbd5d0c5f7638\UnionIntersection\AnotherFoo;
    public function doBar() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Bar;
    public static function doStaticBar() : \_PhpScoperbd5d0c5f7638\UnionIntersection\Bar;
}
interface SomeInterface
{
}
class Dolor
{
    const PARENT_CONSTANT = [1, 2, 3];
}
class Ipsum extends \_PhpScoperbd5d0c5f7638\UnionIntersection\Dolor
{
    const IPSUM_CONSTANT = 'foo';
    /** @var WithFoo|WithFooAndBar */
    private $union;
    /** @var WithFoo|object */
    private $objectUnion;
    public function doFoo(\_PhpScoperbd5d0c5f7638\UnionIntersection\WithFoo $foo, \_PhpScoperbd5d0c5f7638\UnionIntersection\WithFoo $foobar, object $object)
    {
        if ($foo instanceof \_PhpScoperbd5d0c5f7638\UnionIntersection\SomeInterface) {
            if ($foobar instanceof \_PhpScoperbd5d0c5f7638\UnionIntersection\WithFooAndBarInterface) {
                if ($object instanceof \_PhpScoperbd5d0c5f7638\UnionIntersection\SomeInterface) {
                    die;
                }
            }
        }
    }
}
