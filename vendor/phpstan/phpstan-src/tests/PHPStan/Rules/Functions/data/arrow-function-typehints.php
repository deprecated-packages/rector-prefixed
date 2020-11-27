<?php

namespace _PhpScopera143bcca66cb\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScopera143bcca66cb\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScopera143bcca66cb\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScopera143bcca66cb\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
