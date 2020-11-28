<?php

namespace _PhpScoperabd03f0baf05\TestAccessStaticPropertiesAssign;

class AccessStaticPropertyWithDimFetch
{
    public function doFoo()
    {
        self::$foo['foo'] = 'test';
        // already reported by a separate rule
    }
    public function doBar()
    {
        self::$foo = 'test';
    }
}
