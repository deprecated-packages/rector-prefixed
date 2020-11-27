<?php

namespace _PhpScoper26e51eeacccf\TraitsReturnThis;

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
    public function returnsThisWithFoo() : \_PhpScoper26e51eeacccf\TraitsReturnThis\Foo
    {
    }
}
