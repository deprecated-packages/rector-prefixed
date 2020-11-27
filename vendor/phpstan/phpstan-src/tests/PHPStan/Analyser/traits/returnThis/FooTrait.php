<?php

namespace _PhpScoperbd5d0c5f7638\TraitsReturnThis;

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
    public function returnsThisWithFoo() : \_PhpScoperbd5d0c5f7638\TraitsReturnThis\Foo
    {
    }
}
