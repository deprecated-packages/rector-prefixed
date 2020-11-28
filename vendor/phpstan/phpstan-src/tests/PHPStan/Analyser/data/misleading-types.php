<?php

namespace _PhpScoperabd03f0baf05\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScoperabd03f0baf05\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoperabd03f0baf05\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScoperabd03f0baf05\MisleadingTypes\Foo();
    die;
};
