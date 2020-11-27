<?php

namespace _PhpScoper26e51eeacccf\TraitsReturnThis;

class Bar extends \_PhpScoper26e51eeacccf\TraitsReturnThis\Foo
{
    public function doFoo() : void
    {
        (new \_PhpScoper26e51eeacccf\TraitsReturnThis\Foo())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper26e51eeacccf\TraitsReturnThis\Foo())->returnsThisWithFoo()->doFoo();
        (new \_PhpScoper26e51eeacccf\TraitsReturnThis\Bar())->returnsThisWithSelf()->doFoo();
        (new \_PhpScoper26e51eeacccf\TraitsReturnThis\Bar())->returnsThisWithFoo()->doFoo();
    }
}
