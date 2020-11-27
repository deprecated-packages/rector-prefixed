<?php

namespace _PhpScopera143bcca66cb\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScopera143bcca66cb\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
