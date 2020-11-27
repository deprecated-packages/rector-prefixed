<?php

namespace _PhpScoper26e51eeacccf\Bug4017_3;

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
class Baz extends \_PhpScoper26e51eeacccf\Bug4017_3\Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \_PhpScoper26e51eeacccf\Bug4017_3\Bar
{
    /**
     * @template T of \stdClass
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
