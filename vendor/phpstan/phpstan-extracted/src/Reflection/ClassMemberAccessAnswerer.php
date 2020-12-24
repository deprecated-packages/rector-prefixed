<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
