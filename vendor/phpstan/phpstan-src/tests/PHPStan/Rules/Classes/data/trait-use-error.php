<?php

namespace _PhpScoperabd03f0baf05\TraitUseError;

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
