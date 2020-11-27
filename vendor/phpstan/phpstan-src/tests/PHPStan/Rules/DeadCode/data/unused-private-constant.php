<?php

namespace _PhpScoper26e51eeacccf\UnusedPrivateConstant;

class Foo
{
    private const FOO_CONST = 1;
    private const BAR_CONST = 2;
    public function doFoo()
    {
        echo self::FOO_CONST;
    }
}
