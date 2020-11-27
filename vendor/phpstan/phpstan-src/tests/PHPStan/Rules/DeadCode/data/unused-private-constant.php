<?php

namespace _PhpScoperbd5d0c5f7638\UnusedPrivateConstant;

class Foo
{
    private const FOO_CONST = 1;
    private const BAR_CONST = 2;
    public function doFoo()
    {
        echo self::FOO_CONST;
    }
}
