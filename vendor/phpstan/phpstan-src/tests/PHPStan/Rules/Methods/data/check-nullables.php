<?php

namespace _PhpScoper26e51eeacccf\CheckNullables;

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
