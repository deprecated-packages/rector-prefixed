<?php

namespace _PhpScopera143bcca66cb;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
if ((new \PHPStan\Tests\AssertionClass())->assertString($foo) && \PHPStan\Tests\AssertionClass::assertInt($bar)) {
    die;
}
