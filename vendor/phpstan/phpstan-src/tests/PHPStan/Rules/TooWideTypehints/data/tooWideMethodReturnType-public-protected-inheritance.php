<?php

namespace _PhpScoper006a73f0e455\TooWideMethodReturnType;

class Ancestor
{
    public function bar() : ?string
    {
        return null;
    }
}
final class Baz extends \_PhpScoper006a73f0e455\TooWideMethodReturnType\Ancestor
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
class BarClass implements \_PhpScoper006a73f0e455\TooWideMethodReturnType\FooInterface
{
    public function doFoo() : ?string
    {
        return 'fooo';
    }
}
