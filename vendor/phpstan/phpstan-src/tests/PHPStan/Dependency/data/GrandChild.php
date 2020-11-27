<?php

namespace _PhpScoper006a73f0e455\Tests\Dependency;

class GrandChild extends \_PhpScoper006a73f0e455\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScoper006a73f0e455\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScoper006a73f0e455\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
