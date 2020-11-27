<?php

namespace _PhpScoper26e51eeacccf\NewOffsetStub;

/**
 * @phpstan-implements \ArrayAccess<int, \stdClass>
 */
abstract class Foo implements \ArrayAccess
{
}
function (\_PhpScoper26e51eeacccf\NewOffsetStub\Foo $foo) : void {
    $foo[] = new \stdClass();
};
