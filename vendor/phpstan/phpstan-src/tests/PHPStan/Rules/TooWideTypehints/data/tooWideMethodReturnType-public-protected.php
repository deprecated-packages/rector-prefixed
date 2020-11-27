<?php

namespace _PhpScopera143bcca66cb\TooWideMethodReturnType;

final class Bar
{
    public function foo() : \Generator
    {
        (yield 1);
        (yield 2);
        return 3;
    }
    public function bar() : ?string
    {
        return null;
    }
    protected function baz() : ?string
    {
        return 'foo';
    }
    public function lorem() : ?string
    {
        if (\rand(0, 1)) {
            return '1';
        }
        return null;
    }
}
class Bazz
{
    public final function lorem() : ?string
    {
        return null;
    }
}
