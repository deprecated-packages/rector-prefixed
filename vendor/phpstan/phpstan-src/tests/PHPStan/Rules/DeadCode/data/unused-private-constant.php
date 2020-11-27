<?php

namespace _PhpScoper006a73f0e455\UnusedPrivateConstant;

class Foo
{
    private const FOO_CONST = 1;
    private const BAR_CONST = 2;
    public function doFoo()
    {
        echo self::FOO_CONST;
    }
}
