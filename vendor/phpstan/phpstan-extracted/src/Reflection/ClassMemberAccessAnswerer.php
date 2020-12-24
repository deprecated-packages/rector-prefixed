<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
