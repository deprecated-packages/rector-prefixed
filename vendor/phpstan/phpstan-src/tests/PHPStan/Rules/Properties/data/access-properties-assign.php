<?php

namespace _PhpScoperbd5d0c5f7638\TestAccessPropertiesAssign;

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
