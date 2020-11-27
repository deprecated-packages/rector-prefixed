<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScoper88fe6e0ad041\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
