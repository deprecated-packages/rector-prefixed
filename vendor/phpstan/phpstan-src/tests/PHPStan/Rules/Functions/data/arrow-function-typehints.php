<?php

namespace _PhpScoper006a73f0e455\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScoper006a73f0e455\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScoper006a73f0e455\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScoper006a73f0e455\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
