<?php

namespace _PhpScoper26e51eeacccf\TraitUseCase;

trait FooTrait
{
}
class Foo
{
    use FOOTrait;
}
class Bar
{
    use FooTrait;
}
