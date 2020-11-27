<?php

namespace _PhpScoperbd5d0c5f7638\CheckNullables;

class Foo
{
    public function doFoo(string $foo)
    {
        $this->doFoo('foo');
        $this->doFoo(null);
        /** @var string|null $stringOrNull */
        $stringOrNull = doFoo();
        $this->doFoo($stringOrNull);
    }
}
