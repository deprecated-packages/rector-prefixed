<?php

namespace _PhpScoperbd5d0c5f7638\TestAccessStaticPropertiesAssign;

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
