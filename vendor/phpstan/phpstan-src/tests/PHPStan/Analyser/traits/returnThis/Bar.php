<?php

namespace _PhpScoper006a73f0e455\TraitsReturnThis;

class Bar extends \_PhpScoper006a73f0e455\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScoper006a73f0e455\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper006a73f0e455\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScoper006a73f0e455\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper006a73f0e455\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
