<?php

namespace _PhpScoper88fe6e0ad041\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScoper88fe6e0ad041\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper88fe6e0ad041\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScoper88fe6e0ad041\MisleadingTypes\Foo();
    die;
};
