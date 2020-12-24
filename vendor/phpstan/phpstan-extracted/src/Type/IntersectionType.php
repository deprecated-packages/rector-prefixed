<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\Type\IntersectionTypeMethodReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
class IntersectionType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $this->types = \_PhpScopere8e811afab72\PHPStan\Type\UnionTypeHelper::sortTypes($types);
    }
    /**
     * @return Type[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->types);
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        foreach ($this->types as $type) {
            if (!$type->accepts($otherType, $strictTypes)->yes()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType && $this->equals($otherType)) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes()->and(...$results);
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($acceptingType instanceof self || $acceptingType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $acceptingType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (\count($this->types) !== \count($type->types)) {
            return \false;
        }
        foreach ($this->types as $i => $innerType) {
            if (!$innerType->equals($type->types[$i])) {
                return \false;
            }
        }
        return \true;
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType) {
                    continue;
                }
                $typeNames[] = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($type)->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryNumericStringType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType) {
                    continue;
                }
                $typeNames[] = $type->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                $typeNames[] = $type->describe($level);
            }
            return \implode('&', $typeNames);
        });
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasProperty($propertyName)->yes()) {
                return $type->getProperty($propertyName, $scope);
            }
        }
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        $methods = [];
        foreach ($this->types as $type) {
            if (!$type->hasMethod($methodName)->yes()) {
                continue;
            }
            $methods[] = $type->getMethod($methodName, $scope);
        }
        $methodsCount = \count($methods);
        if ($methodsCount === 0) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Type\IntersectionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasConstant($constantName)->yes()) {
                return $type->getConstant($constantName);
            }
        }
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($offsetType) : Type {
            return $type->getOffsetValueType($offsetType);
        });
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        }
        return $type;
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\_PhpScopere8e811afab72\PHPStan\Type\Type $templateType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($templateType->inferTemplateTypes($type));
        }
        return $types;
    }
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = [];
        foreach ($this->types as $type) {
            foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        $changed = \false;
        foreach ($this->types as $type) {
            $newType = $cb($type);
            if ($type !== $newType) {
                $changed = \true;
            }
            $types[] = $newType;
        }
        if ($changed) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(...$types);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['types']);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $getResult
     * @return TrinaryLogic
     */
    private function intersectResults(callable $getResult) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $operands = \array_map($getResult, $this->types);
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::maxMin(...$operands);
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    private function intersectTypes(callable $getType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $operands = \array_map($getType, $this->types);
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(...$operands);
    }
}
