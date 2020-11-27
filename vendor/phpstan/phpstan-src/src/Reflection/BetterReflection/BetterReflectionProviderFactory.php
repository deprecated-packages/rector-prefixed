<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScopera143bcca66cb\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
