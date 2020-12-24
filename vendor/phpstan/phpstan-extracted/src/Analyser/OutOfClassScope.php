<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
class OutOfClassScope implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function isInClass() : bool
    {
        return \false;
    }
    public function getClassReflection() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        return null;
    }
    public function canAccessProperty(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool
    {
        return $propertyReflection->isPublic();
    }
    public function canCallMethod(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->isPublic();
    }
    public function canAccessConstant(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection $constantReflection) : bool
    {
        return $constantReflection->isPublic();
    }
}
