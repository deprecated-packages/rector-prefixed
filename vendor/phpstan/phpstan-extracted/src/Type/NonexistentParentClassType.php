<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Traits\NonCallableTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\NonIterableTypeTrait;
use PHPStan\Type\Traits\NonOffsetAccessibleTypeTrait;
use PHPStan\Type\Traits\TruthyBooleanTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class NonexistentParentClassType implements \PHPStan\Type\Type
{
    use JustNullableTypeTrait;
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonOffsetAccessibleTypeTrait;
    use TruthyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'parent';
    }
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
    {
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self();
    }
}
