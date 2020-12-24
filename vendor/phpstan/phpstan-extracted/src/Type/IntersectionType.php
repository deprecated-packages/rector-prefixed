<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Type\IntersectionTypeMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
class IntersectionType implements \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $this->types = \_PhpScoperb75b35f52b74\PHPStan\Type\UnionTypeHelper::sortTypes($types);
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
        return \_PhpScoperb75b35f52b74\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->types);
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        foreach ($this->types as $type) {
            if (!$type->accepts($otherType, $strictTypes)->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType && $this->equals($otherType)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes()->and(...$results);
    }
    public function isSubTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $otherType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($acceptingType instanceof self || $acceptingType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return $acceptingType->isSuperTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::maxMin(...$results);
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
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
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryType) {
                    continue;
                }
                $typeNames[] = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::generalizeType($type)->describe($level);
            }
            return \implode('&', $typeNames);
        }, function () use($level) : string {
            $typeNames = [];
            foreach ($this->types as $type) {
                if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType) {
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
    public function canAccessProperties() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasProperty($propertyName)->yes()) {
                return $type->getProperty($propertyName, $scope);
            }
        }
        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
    }
    public function canCallMethods() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
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
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Type\IntersectionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection
    {
        foreach ($this->types as $type) {
            if ($type->hasConstant($constantName)->yes()) {
                return $type->getConstant($constantName);
            }
        }
        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
    }
    public function isIterable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($offsetType) : Type {
            return $type->getOffsetValueType($offsetType);
        });
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->isCallable()->no()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function isCloneable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->intersectResults(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
        }
        return $type;
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->intersectTypes(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $templateType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->intersect($templateType->inferTemplateTypes($type));
        }
        return $types;
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = [];
        foreach ($this->types as $type) {
            foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(...$types);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['types']);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $getResult
     * @return TrinaryLogic
     */
    private function intersectResults(callable $getResult) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        $operands = \array_map($getResult, $this->types);
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::maxMin(...$operands);
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    private function intersectTypes(callable $getType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $operands = \array_map($getType, $this->types);
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(...$operands);
    }
}
