<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScoper006a73f0e455\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
