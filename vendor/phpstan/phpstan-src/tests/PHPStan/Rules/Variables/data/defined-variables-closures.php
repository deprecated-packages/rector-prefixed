<?php

namespace _PhpScoperbd5d0c5f7638\DefinedVariablesClosures;

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
