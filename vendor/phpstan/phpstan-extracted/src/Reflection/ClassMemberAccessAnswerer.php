<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

interface ClassMemberAccessAnswerer
{
    public function isInClass() : bool;
    public function getClassReflection() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
    public function canAccessProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool;
    public function canCallMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function canAccessConstant(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection $constantReflection) : bool;
}
