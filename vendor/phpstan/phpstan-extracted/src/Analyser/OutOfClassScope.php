<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
class OutOfClassScope implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function isInClass() : bool
    {
        return \false;
    }
    public function getClassReflection() : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection
    {
        return null;
    }
    public function canAccessProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool
    {
        return $propertyReflection->isPublic();
    }
    public function canCallMethod(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->isPublic();
    }
    public function canAccessConstant(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection $constantReflection) : bool
    {
        return $constantReflection->isPublic();
    }
}
