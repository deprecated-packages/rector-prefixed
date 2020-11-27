<?php

namespace _PhpScoper006a73f0e455\Bug4017_2;

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
class Baz extends \_PhpScoper006a73f0e455\Bug4017_2\Bar
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
class Lorem extends \_PhpScoper006a73f0e455\Bug4017_2\Bar
{
    /**
     * @param Foo $a
     */
    public function doFoo($a)
    {
    }
}
