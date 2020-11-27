<?php

namespace _PhpScoper006a73f0e455\TooWideClosureReturnType;

class Foo
{
    public function doFoo()
    {
        function () : \Generator {
            (yield 1);
            (yield 2);
            return 3;
        };
        function () : ?string {
            return null;
        };
        function () : ?string {
            return 'foo';
        };
        function () : ?string {
            if (\rand(0, 1)) {
                return '1';
            }
            return null;
        };
    }
}
