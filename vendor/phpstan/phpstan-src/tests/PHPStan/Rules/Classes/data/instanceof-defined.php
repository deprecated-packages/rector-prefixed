<?php

namespace _PhpScoper26e51eeacccf\InstanceOfNamespace;

class Foo
{
    public function foobar()
    {
        if ($this instanceof self) {
        }
    }
}
