<?php

namespace _PhpScoper006a73f0e455\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScoper006a73f0e455\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
