<?php

namespace _PhpScoperabd03f0baf05\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScoperabd03f0baf05\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
