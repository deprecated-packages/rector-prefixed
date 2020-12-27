<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
