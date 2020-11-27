<?php

// lint >= 7.4
namespace _PhpScoper88fe6e0ad041\RequiredAfterOptional;

fn($foo = null, $bar): int => 1;
// not OK
fn(int $foo = null, $bar): int => 1;
// is OK
fn(int $foo = 1, $bar): int => 1;
// not OK
fn(bool $foo = \true, $bar): int => 1;
// not OK
