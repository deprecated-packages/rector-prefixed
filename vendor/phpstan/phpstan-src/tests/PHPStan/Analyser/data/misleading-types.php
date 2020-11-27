<?php

namespace _PhpScoper006a73f0e455\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScoper006a73f0e455\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper006a73f0e455\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScoper006a73f0e455\MisleadingTypes\Foo();
    die;
};
