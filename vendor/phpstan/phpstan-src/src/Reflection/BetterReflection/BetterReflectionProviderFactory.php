<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
