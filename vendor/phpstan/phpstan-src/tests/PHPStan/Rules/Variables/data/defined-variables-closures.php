<?php

namespace _PhpScoperabd03f0baf05\DefinedVariablesClosures;

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
