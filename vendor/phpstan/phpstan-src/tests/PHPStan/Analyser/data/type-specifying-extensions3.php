<?php

namespace _PhpScoper006a73f0e455;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
if ((new \PHPStan\Tests\AssertionClass())->assertString($foo) && \PHPStan\Tests\AssertionClass::assertInt($bar)) {
    die;
}
