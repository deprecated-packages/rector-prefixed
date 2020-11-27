<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionClass;
interface ClassPrinterInterface
{
    public function __invoke(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string;
}
