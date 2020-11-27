<?php

namespace _PhpScoper26e51eeacccf\Tests\Dependency;

class GrandChild extends \_PhpScoper26e51eeacccf\Tests\Dependency\Child
{
    /**
     * @param ParamPhpDocReturnTypehint $param
     * @return MethodPhpDocReturnTypehint
     */
    public function doFoo(\_PhpScoper26e51eeacccf\Tests\Dependency\ParamNativeReturnTypehint $param) : \_PhpScoper26e51eeacccf\Tests\Dependency\MethodNativeReturnTypehint
    {
        [, $a, $b] = [1, 2, 3];
    }
}
