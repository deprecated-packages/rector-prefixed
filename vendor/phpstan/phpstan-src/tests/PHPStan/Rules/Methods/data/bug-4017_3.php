<?php

namespace _PhpScoperabd03f0baf05\Bug4017_3;

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
class Baz extends \_PhpScoperabd03f0baf05\Bug4017_3\Bar
{
    /**
     * @template T of Foo
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
class Lorem extends \_PhpScoperabd03f0baf05\Bug4017_3\Bar
{
    /**
     * @template T of \stdClass
     * @param T $a
     */
    public function doFoo($a)
    {
    }
}
