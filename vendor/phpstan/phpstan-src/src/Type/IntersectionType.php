<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\Reflection\Type\IntersectionTypeMethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\Accessory\AccessoryType;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
class IntersectionType implements \PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $this->types = \PHPStan\Type\UnionTypeHelper::sortTypes($types);
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
        return \PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->types);
    }
    public function accepts(\PHPStan\Type\Type $otherType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        foreach ($this->types as $type) {
            if (!$type->accepts($otherType, $strictTypes)->yes()) {
                return \PHPStan\TrinaryLogic::createNo();
            }
        }
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\IntersectionType && $this->equals($otherType)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \PHPStan\TrinaryLogic::createYes()->and(...$results);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($acceptingType instanceof self || $acceptingType instanceof \PHPStan\Type\UnionType) {
            return $acceptingType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
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
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \PHPStan\Type\Accessory\AccessoryType) {
                    continue;
                }
                $typeNames[] = \PHPStan\Type\TypeUtils::generalizeType($type)->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \PHPStan\Type\Accessory\AccessoryType && !$type instanceof \PHPStan\Type\Accessory\AccessoryNumericStringType && !$type instanceof \PHPStan\Type\Accessory\NonEmptyArrayType) {
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
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasProperty($propertyName)->yes()) {
                return $type->getProperty($propertyName, $scope);
            }
        }
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
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
            throw new \PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \PHPStan\Reflection\Type\IntersectionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasConstant($constantName)->yes()) {
                return $type->getConstant($constantName);
            }
        }
        throw new \PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\PHPStan\Type\Type $type) use($offsetType) : Type {
            return $type->getOffsetValueType($offsetType);
        });
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        if (!$type instanceof \PHPStan\Type\BooleanType) {
            return new \PHPStan\Type\BooleanType();
        }
        return $type;
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\PHPStan\Type\Type $templateType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($templateType->inferTemplateTypes($type));
        }
        return $types;
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = [];
        foreach ($this->types as $type) {
            foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
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
            return \PHPStan\Type\TypeCombinator::intersect(...$types);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['types']);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $getResult
     * @return TrinaryLogic
     */
    private function intersectResults(callable $getResult) : \PHPStan\TrinaryLogic
    {
        $operands = \array_map($getResult, $this->types);
        return \PHPStan\TrinaryLogic::maxMin(...$operands);
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    private function intersectTypes(callable $getType) : \PHPStan\Type\Type
    {
        $operands = \array_map($getType, $this->types);
        return \PHPStan\Type\TypeCombinator::intersect(...$operands);
    }
}
