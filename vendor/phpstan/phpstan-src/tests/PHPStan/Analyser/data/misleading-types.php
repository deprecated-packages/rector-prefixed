<?php

namespace _PhpScopera143bcca66cb\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScopera143bcca66cb\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScopera143bcca66cb\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScopera143bcca66cb\MisleadingTypes\Foo();
    die;
};
