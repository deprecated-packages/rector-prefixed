<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\RectorPrefix20201227\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
