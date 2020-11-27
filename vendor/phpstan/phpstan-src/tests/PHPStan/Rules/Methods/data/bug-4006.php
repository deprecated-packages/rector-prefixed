<?php

namespace _PhpScoperbd5d0c5f7638\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScoperbd5d0c5f7638\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
