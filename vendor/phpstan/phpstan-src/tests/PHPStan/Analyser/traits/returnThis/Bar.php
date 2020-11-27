<?php

namespace _PhpScoperbd5d0c5f7638\TraitsReturnThis;

class Bar extends \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
