<?php

namespace _PhpScoperabd03f0baf05;

/** @var string|null $foo */
$foo = null;
/** @var int|null $bar */
$bar = null;
(new \PHPStan\Tests\AssertionClass())->assertString($foo);
$test = \PHPStan\Tests\AssertionClass::assertInt($bar);
die;
