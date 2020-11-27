<?php

namespace _PhpScoper006a73f0e455\TestAccessPropertiesAssign;

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
