<?php

namespace _PhpScoper006a73f0e455\TraitsReturnThis;

trait FooTrait
{
    /**
     * @return $this
     */
    public function returnsThisWithSelf() : self
    {
    }
    /**
     * @return $this
     */
    public function returnsThisWithFoo() : \_PhpScoper006a73f0e455\TraitsReturnThis\Foo
    {
    }
}
