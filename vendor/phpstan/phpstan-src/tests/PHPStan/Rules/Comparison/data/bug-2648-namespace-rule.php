<?php

namespace _PhpScoper88fe6e0ad041\Bug2648Rule;

/** @var array<string> $foo */
$foo = $_GET['bar'];
if (\count($foo) > 0) {
    foreach ($foo as $key => $value) {
        unset($foo[$key]);
    }
    if (\count($foo) > 0) {
        // $foo is actually empty now
    }
}
