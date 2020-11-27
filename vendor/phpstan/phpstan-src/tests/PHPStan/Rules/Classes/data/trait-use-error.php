<?php

namespace _PhpScoper26e51eeacccf\TraitUseError;

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
