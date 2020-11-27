<?php

namespace _PhpScopera143bcca66cb\DefinedVariablesClosures;

class Foo
{
    public function doFoo()
    {
        function () {
            \var_dump($this);
        };
        static function () {
            \var_dump($this);
        };
    }
}
