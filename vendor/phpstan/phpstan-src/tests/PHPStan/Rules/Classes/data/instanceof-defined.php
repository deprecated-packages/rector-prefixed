<?php

namespace _PhpScoperbd5d0c5f7638\InstanceOfNamespace;

class Foo
{
    public function foobar()
    {
        if ($this instanceof self) {
        }
    }
}
