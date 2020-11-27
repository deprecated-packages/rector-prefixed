<?php

namespace _PhpScoperbd5d0c5f7638\Tests\Dependency;

class GrandChild extends \_PhpScoperbd5d0c5f7638\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScoperbd5d0c5f7638\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScoperbd5d0c5f7638\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
