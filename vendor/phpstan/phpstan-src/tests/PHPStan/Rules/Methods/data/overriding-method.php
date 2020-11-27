<?php

namespace _PhpScoper88fe6e0ad041\OverridingFinalMethod;

class Foo
{
    public final function doFoo()
    {
    }
    public function doBar()
    {
    }
    public function doBaz()
    {
    }
    protected function doLorem()
    {
    }
    public static function doIpsum()
    {
    }
    public function doDolor()
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Foo
{
    public function doFoo()
    {
    }
    private function doBar()
    {
    }
    protected function doBaz()
    {
    }
    private function doLorem()
    {
    }
    public function doIpsum()
    {
    }
    public static function doDolor()
    {
    }
}
class Baz
{
    public function __construct(int $i)
    {
    }
}
class Lorem extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Baz
{
    public function __construct(string $s)
    {
    }
}
abstract class Ipsum
{
    public abstract function __construct(int $i);
    public function doFoo(int $i)
    {
    }
}
class Dolor extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Ipsum
{
    public function __construct(string $s)
    {
    }
    public function doFoo()
    {
    }
}
class FixedArray extends \SplFixedArray
{
    public function setSize(int $size) : bool
    {
    }
}
class Sit
{
    public function doFoo(int $i, int $j = null)
    {
    }
    public function doBar(int ...$j)
    {
    }
    public function doBaz(int $j)
    {
    }
}
class Amet extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Sit
{
    public function doFoo(int $i = null, int $j = null)
    {
    }
    public function doBar(int $j)
    {
    }
    public function doBaz(int ...$j)
    {
    }
}
class Consecteur extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Sit
{
    public function doFoo(int $i, ?int $j)
    {
    }
}
class Etiam
{
    public function doFoo(int &$i, int $j)
    {
    }
}
class Lacus extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Etiam
{
    public function doFoo(int $i, int &$j)
    {
    }
}
class BazBaz extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Foo
{
    public function doBar(int $i)
    {
    }
}
class BazBazBaz extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Foo
{
    public function doBar(int $i = null)
    {
    }
}
class FooFoo extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Ipsum
{
    public function doFoo(int $i, int $j)
    {
    }
}
class FooFooFoo extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Ipsum
{
    public function doFoo(int $i, int $j = null)
    {
    }
}
/**
 * @implements \IteratorAggregate<int, Foo>
 */
class SomeIterator implements \IteratorAggregate
{
    /**
     * @return \Traversable<int, Foo>
     */
    public function getIterator()
    {
        (yield new \_PhpScoper88fe6e0ad041\OverridingFinalMethod\Foo());
    }
}
class SomeException extends \Exception
{
    private function __construct()
    {
    }
}
class OtherException extends \Exception
{
    public final function __construct()
    {
    }
}
class SomeOtherException extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\OtherException
{
    public function __construct()
    {
    }
}
class FinalWithAnnotation
{
    /**
     * @final
     */
    public function doFoo()
    {
    }
}
class ExtendsFinalWithAnnotation extends \_PhpScoper88fe6e0ad041\OverridingFinalMethod\FinalWithAnnotation
{
    public function doFoo()
    {
    }
}
class FixedArrayOffsetExists extends \SplFixedArray
{
    public function offsetExists(int $index)
    {
    }
}