<?php

namespace _PhpScopera143bcca66cb;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
(new \PHPStan\Tests\AssertionClass())->assertString($foo);
$test = \PHPStan\Tests\AssertionClass::assertInt($bar);
die;
