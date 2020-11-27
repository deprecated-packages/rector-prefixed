<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
