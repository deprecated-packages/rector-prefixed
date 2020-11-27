<?php

namespace _PhpScoper006a73f0e455\DefinedVariablesClosures;

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
