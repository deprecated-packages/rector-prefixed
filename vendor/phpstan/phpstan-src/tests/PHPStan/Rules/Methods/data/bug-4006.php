<?php

namespace _PhpScoper88fe6e0ad041\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScoper88fe6e0ad041\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
