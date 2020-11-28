<?php

namespace _PhpScoperabd03f0baf05\TraitsReturnThis;

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
    public function returnsThisWithFoo() : \_PhpScoperabd03f0baf05\TraitsReturnThis\Foo
    {
    }
}
