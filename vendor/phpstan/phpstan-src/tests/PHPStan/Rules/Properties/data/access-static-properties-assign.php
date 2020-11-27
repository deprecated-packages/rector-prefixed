<?php

namespace _PhpScoper006a73f0e455\TestAccessStaticPropertiesAssign;

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
