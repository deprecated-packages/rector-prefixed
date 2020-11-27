<?php

namespace _PhpScoper006a73f0e455\Bug4017_3;

class Foo
{
}
class Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Baz extends \_PhpScoper006a73f0e455\Bug4017_3\Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \_PhpScoper006a73f0e455\Bug4017_3\Bar
{
    /**
     * @template T of \stdClass
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
