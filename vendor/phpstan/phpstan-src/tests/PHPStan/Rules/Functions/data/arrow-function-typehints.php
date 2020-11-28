<?php

namespace _PhpScoperabd03f0baf05\ArrowFunctionExistingClassesInTypehints;

class Foo
{
    public function doFoo()
    {
        fn(\_PhpScoperabd03f0baf05\ArrowFunctionExistingClassesInTypehints\Bar $bar): \_PhpScoperabd03f0baf05\ArrowFunctionExistingClassesInTypehints\Baz => new \_PhpScoperabd03f0baf05\ArrowFunctionExistingClassesInTypehints\Baz();
    }
}
