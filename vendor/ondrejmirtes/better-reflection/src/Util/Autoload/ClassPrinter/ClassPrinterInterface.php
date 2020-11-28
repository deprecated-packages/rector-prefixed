<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass;
interface ClassPrinterInterface
{
    public function __invoke(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string;
}
