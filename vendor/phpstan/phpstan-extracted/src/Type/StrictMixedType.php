<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class StrictMixedType implements \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType
{
    use UndecidedComparisonCompoundTypeTrait;
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isAcceptedBy(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($acceptingType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType && !$acceptingType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateMixedType);
    }
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($type instanceof self);
    }
    public function isSubTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $otherType) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($otherType instanceof self);
    }
    public function equals(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'mixed';
    }
    public function canAccessProperties() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getProperty(string $propertyName, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertyReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getMethod(string $methodName, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function canAccessConstants() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getConstant(string $constantName) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ConstantReflection
    {
        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    public function getIterableValueType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isOffsetAccessible() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $offsetType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $valueType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function isCallable() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function getCallableParametersAcceptors(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [];
    }
    public function isCloneable() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function toBoolean() : \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType();
    }
    public function toNumber() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
    }
    public function inferTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $receivedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
    public function traverse(callable $cb) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self();
    }
}
