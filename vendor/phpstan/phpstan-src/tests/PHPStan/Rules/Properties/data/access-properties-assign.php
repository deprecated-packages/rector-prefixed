<?php

namespace _PhpScoperabd03f0baf05\TestAccessPropertiesAssign;

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
