<?php

// lint >= 7.4
namespace _PhpScoper26e51eeacccf\RequiredAfterOptional;

fn($foo = null, $bar): int => 1;
// not OK
fn(int $foo = null, $bar): int => 1;
// is OK
fn(int $foo = 1, $bar): int => 1;
// not OK
fn(bool $foo = \true, $bar): int => 1;
// not OK
