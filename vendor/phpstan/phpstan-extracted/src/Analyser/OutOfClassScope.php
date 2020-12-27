<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
class OutOfClassScope implements \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer
{
    public function isInClass() : bool
    {
        return \false;
    }
    public function getClassReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return null;
    }
    public function canAccessProperty(\RectorPrefix20201227\PHPStan\Reflection\PropertyReflection $propertyReflection) : bool
    {
        return $propertyReflection->isPublic();
    }
    public function canCallMethod(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->isPublic();
    }
    public function canAccessConstant(\RectorPrefix20201227\PHPStan\Reflection\ConstantReflection $constantReflection) : bool
    {
        return $constantReflection->isPublic();
    }
}
