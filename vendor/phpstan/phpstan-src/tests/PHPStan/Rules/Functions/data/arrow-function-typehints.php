<?php

namespace _PhpScoperbd5d0c5f7638\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScoperbd5d0c5f7638\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScoperbd5d0c5f7638\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScoperbd5d0c5f7638\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
