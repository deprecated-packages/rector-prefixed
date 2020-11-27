<?php

namespace _PhpScoper26e51eeacccf\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScoper26e51eeacccf\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper26e51eeacccf\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScoper26e51eeacccf\MisleadingTypes\Foo();
    die;
};
