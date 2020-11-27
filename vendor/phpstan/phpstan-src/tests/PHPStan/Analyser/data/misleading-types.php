<?php

namespace _PhpScoperbd5d0c5f7638\MisleadingTypes;

class Foo
{
    public function misleadingBoolReturnType() : \_PhpScoperbd5d0c5f7638\MisleadingTypes\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoperbd5d0c5f7638\MisleadingTypes\integer
    {
    }
    public function misleadingMixedReturnType() : mixed
    {
    }
}
function () {
    $foo = new \_PhpScoperbd5d0c5f7638\MisleadingTypes\Foo();
    die;
};
