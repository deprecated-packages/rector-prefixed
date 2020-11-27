<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass;
interface ClassPrinterInterface
{
    public function __invoke(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string;
}
