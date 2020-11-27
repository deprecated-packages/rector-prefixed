<?php

namespace _PhpScoper88fe6e0ad041\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScoper88fe6e0ad041\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScoper88fe6e0ad041\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScoper88fe6e0ad041\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
