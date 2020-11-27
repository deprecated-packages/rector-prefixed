<?php

namespace _PhpScoper006a73f0e455;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
(new \PHPStan\Tests\AssertionClass())->assertString($foo);
$test = \PHPStan\Tests\AssertionClass::assertInt($bar);
die;
