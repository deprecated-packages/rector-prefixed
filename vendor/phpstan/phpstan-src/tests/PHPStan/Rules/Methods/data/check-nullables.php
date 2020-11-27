<?php

namespace _PhpScoper006a73f0e455\CheckNullables;

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
