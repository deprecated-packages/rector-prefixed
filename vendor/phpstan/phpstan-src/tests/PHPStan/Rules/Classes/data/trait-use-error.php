<?php

namespace _PhpScoper006a73f0e455\TraitUseError;

class Foo
{
    use FooTrait;
}
trait BarTrait
{
    use Foo, FooTrait;
}
interface Baz
{
    use BarTrait;
}
new class
{
    use FooTrait;
    use Baz;
};
