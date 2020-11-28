<?php

namespace _PhpScoperabd03f0baf05\Tests\Dependency;

class GrandChild extends \_PhpScoperabd03f0baf05\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScoperabd03f0baf05\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScoperabd03f0baf05\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
