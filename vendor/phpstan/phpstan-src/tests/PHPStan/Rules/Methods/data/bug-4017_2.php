<?php

namespace _PhpScoper88fe6e0ad041\Bug4017_2;

class Foo
{
}
/**
 * @template T
 */
class Bar
{
    /**
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
/**
 * @extends Bar<Foo>
 */
class Baz extends \_PhpScoper88fe6e0ad041\Bug4017_2\Bar
{
    /**
     * @param Foo $a
     */
    public function doFoo($a)
    {
    }
}
/**
 * @extends Bar<\stdClass>
 */
class Lorem extends \_PhpScoper88fe6e0ad041\Bug4017_2\Bar
{
    /**
     * @param Foo $a
     */
    public function doFoo($a)
    {
    }
}
