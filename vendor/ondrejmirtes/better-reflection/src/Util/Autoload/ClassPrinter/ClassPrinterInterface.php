<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass;
interface ClassPrinterInterface
{
    public function __invoke(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string;
}
