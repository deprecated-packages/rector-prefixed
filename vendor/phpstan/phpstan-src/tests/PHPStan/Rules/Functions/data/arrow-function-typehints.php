<?php

namespace _PhpScoper26e51eeacccf\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScoper26e51eeacccf\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScoper26e51eeacccf\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScoper26e51eeacccf\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
