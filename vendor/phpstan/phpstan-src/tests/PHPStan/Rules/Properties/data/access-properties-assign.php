<?php

namespace _PhpScoper88fe6e0ad041\TestAccessPropertiesAssign;

class AccessPropertyWithDimFetch
{
    public function doFoo()
    {
        $this->foo['foo'] = 'test';
        // already reported by a separate rule
    }
    public function doBar()
    {
        $this->foo = 'test';
    }
}
