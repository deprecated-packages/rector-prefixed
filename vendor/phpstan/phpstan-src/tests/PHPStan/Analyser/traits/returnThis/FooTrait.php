<?php

namespace _PhpScoper88fe6e0ad041\TraitsReturnThis;

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
    public function returnsThisWithFoo() : \_PhpScoper88fe6e0ad041\TraitsReturnThis\Foo
    {
    }
}
