<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _PhpScoper26e51eeacccf\Roave\BetterReflection\Reflection\ReflectionClass;
interface LoaderMethodInterface
{
    public function __invoke(\_PhpScoper26e51eeacccf\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void;
}
