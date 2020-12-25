<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\Autoload\ClassLoaderMethod;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
interface LoaderMethodInterface
{
    public function __invoke(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass $classInfo) : void;
}
