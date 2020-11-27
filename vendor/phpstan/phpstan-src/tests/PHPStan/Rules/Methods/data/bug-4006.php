<?php

namespace _PhpScoper26e51eeacccf\Bug4006;

interface Foo
{
    /**
     * @return never
     */
    public function bar();
}
class Bar implements \_PhpScoper26e51eeacccf\Bug4006\Foo
{
    public function bar() : void
    {
        throw new \Exception();
    }
}
