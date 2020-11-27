<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Util\Autoload\ClassPrinter;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass;
interface ClassPrinterInterface
{
    public function __invoke(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : string;
}
