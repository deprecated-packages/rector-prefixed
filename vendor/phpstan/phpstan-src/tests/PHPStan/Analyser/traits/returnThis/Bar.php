<?php

namespace _PhpScopera143bcca66cb\TraitsReturnThis;

class Bar extends \_PhpScopera143bcca66cb\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScopera143bcca66cb\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScopera143bcca66cb\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScopera143bcca66cb\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScopera143bcca66cb\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
