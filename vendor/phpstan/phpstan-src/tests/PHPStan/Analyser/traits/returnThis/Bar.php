<?php

namespace _PhpScoperabd03f0baf05\TraitsReturnThis;

class Bar extends \_PhpScoperabd03f0baf05\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScoperabd03f0baf05\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoperabd03f0baf05\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScoperabd03f0baf05\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoperabd03f0baf05\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
