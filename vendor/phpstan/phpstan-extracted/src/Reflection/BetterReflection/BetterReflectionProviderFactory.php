<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
interface BetterReflectionProviderFactory
{
    public function create(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector $functionReflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ConstantReflector $constantReflector) : \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\BetterReflectionProvider;
}
