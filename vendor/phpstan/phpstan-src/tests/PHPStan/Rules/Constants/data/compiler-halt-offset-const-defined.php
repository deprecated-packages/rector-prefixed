<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

function greet(string $name) : string
{
    $template = \file_get_contents(__FILE__, \false, null, \__COMPILER_HALT_OFFSET__);
    return \strtr($template, ['%name%' => $name]);
}
echo \_PhpScopera143bcca66cb\greet('Bob');
__halt_compiler();
Hello, %name%!

