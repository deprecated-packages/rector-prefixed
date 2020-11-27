<?php

namespace _PhpScopera143bcca66cb\Tests\Dependency;

class GrandChild extends \_PhpScopera143bcca66cb\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScopera143bcca66cb\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScopera143bcca66cb\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
