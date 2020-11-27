<?php

namespace _PhpScoper006a73f0e455\NewOffsetStub;

/**
 * @phpstan-implements \ArrayAccess<int, \stdClass>
 */
abstract class Foo implements \ArrayAccess
{
}
function (\_PhpScoper006a73f0e455\NewOffsetStub\Foo $foo) : void {
    $foo[] = new \stdClass();
};
