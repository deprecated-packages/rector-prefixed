<?php

namespace _PhpScoper88fe6e0ad041\Tests\Dependency;

class GrandChild extends \_PhpScoper88fe6e0ad041\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScoper88fe6e0ad041\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScoper88fe6e0ad041\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
