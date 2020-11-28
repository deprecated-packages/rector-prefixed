<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection;

use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScoperabd03f0baf05\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
