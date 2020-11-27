<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

function greet(string $name) : string
{
    $template = \file_get_contents(__FILE__, \false, null, \__COMPILER_HALT_OFFSET__);
    return \strtr($template, ['%name%' => $name]);
}
echo \_PhpScoper006a73f0e455\greet('Bob');
__halt_compiler();
Hello, %name%!

