<?php

namespace _PhpScopera143bcca66cb\TraitUseError;

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
