<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
