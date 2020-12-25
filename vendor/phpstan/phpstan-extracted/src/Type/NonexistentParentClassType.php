<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
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
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
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
