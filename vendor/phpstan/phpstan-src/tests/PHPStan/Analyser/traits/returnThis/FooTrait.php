<?php

namespace _PhpScopera143bcca66cb\TraitsReturnThis;

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
    public function returnsThisWithFoo() : \_PhpScopera143bcca66cb\TraitsReturnThis\Foo
    {
    }
}
