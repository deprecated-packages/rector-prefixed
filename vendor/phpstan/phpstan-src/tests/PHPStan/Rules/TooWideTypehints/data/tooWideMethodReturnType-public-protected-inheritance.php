<?php

namespace _PhpScoperbd5d0c5f7638\TooWideMethodReturnType;

class Ancestor
{
    public function bar() : ?string
    {
        return null;
    }
}
final class Baz extends \_PhpScoperbd5d0c5f7638\TooWideMethodReturnType\Ancestor
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
interface FooInterface
{
    public function doFoo() : ?string;
}
class BarClass implements \_PhpScoperbd5d0c5f7638\TooWideMethodReturnType\FooInterface
{
    public function doFoo() : ?string
    {
        return 'fooo';
    }
}
