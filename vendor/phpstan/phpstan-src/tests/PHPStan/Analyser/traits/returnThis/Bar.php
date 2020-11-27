<?php

namespace _PhpScoper88fe6e0ad041\TraitsReturnThis;

class Bar extends \_PhpScoper88fe6e0ad041\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScoper88fe6e0ad041\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper88fe6e0ad041\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScoper88fe6e0ad041\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper88fe6e0ad041\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
