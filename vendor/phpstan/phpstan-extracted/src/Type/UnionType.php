<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Type\UnionTypeMethodReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance;
class UnionType implements \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $throwException = static function () use($types) : void {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Cannot create %s with: %s', self::class, \implode(', ', \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : string {
                return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::value());
            }, $types))));
        };
        if (\count($types) < 2) {
            $throwException();
        }
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                continue;
            }
            $throwException();
        }
        $this->types = \_PhpScopere8e811afab72\PHPStan\Type\UnionTypeHelper::sortTypes($types);
    }
    /**
     * @return \PHPStan\Type\Type[]
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
        return \_PhpScopere8e811afab72\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->getTypes());
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CallableType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->accepts($type, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
            return $otherType->isSubTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof static) {
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
        $joinTypes = static function (array $types) use($level) : string {
            $typeNames = [];
            foreach ($types as $type) {
                if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ClosureType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CallableType) {
                    $typeNames[] = \sprintf('(%s)', $type->describe($level));
                } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
                    $intersectionDescription = $type->describe($level);
                    if (\strpos($intersectionDescription, '&') !== \false) {
                        $typeNames[] = \sprintf('(%s)', $type->describe($level));
                    } else {
                        $typeNames[] = $intersectionDescription;
                    }
                } else {
                    $typeNames[] = $type->describe($level);
                }
            }
            return \implode('|', $typeNames);
        };
        return $level->handle(function () use($joinTypes) : string {
            $types = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
                if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $type->generalize();
                }
                return $type;
            }, $this->types));
            if ($types instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                return $joinTypes($types->getTypes());
            }
            return $joinTypes([$types]);
        }, function () use($joinTypes) : string {
            return $joinTypes($this->types);
        });
    }
    /**
     * @param callable(Type $type): TrinaryLogic $canCallback
     * @param callable(Type $type): TrinaryLogic $hasCallback
     * @return TrinaryLogic
     */
    private function hasInternal(callable $canCallback, callable $hasCallback) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->types as $type) {
            if ($canCallback($type)->no()) {
                $results[] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
                continue;
            }
            $results[] = $hasCallback($type);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $hasCallback
     * @param callable(Type $type): object $getCallback
     * @return object
     */
    private function getInternal(callable $hasCallback, callable $getCallback)
    {
        /** @var TrinaryLogic|null $result */
        $result = null;
        /** @var object|null $object */
        $object = null;
        foreach ($this->types as $type) {
            $has = $hasCallback($type);
            if (!$has->yes()) {
                continue;
            }
            if ($result !== null && $result->compareTo($has) !== $has) {
                continue;
            }
            $get = $getCallback($type);
            $result = $has;
            $object = $get;
        }
        if ($object === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $object;
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        return $this->getInternal(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        }, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($propertyName, $scope) : PropertyReflection {
            return $type->getProperty($propertyName, $scope);
        });
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
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
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Type\UnionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->hasInternal(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        }, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        return $this->getInternal(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        }, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($constantName) : ConstantReflection {
            return $type->getConstant($constantName);
        });
    }
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        foreach ($this->types as $innerType) {
            $valueType = $innerType->getOffsetValueType($offsetType);
            if ($valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
                continue;
            }
            $types[] = $valueType;
        }
        if (\count($types) === 0) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        foreach ($this->types as $type) {
            if ($type->isCallable()->no()) {
                continue;
            }
            return $type->getCallableParametersAcceptors($scope);
        }
        throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        /** @var BooleanType $type */
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        return $type;
    }
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\_PhpScopere8e811afab72\PHPStan\Type\Type $templateType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($templateType->inferTemplateTypes($type));
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
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types);
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
    private function unionResults(callable $getResult) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::extremeIdentity(...\array_map($getResult, $this->types));
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    protected function unionTypes(callable $getType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...\array_map($getType, $this->types));
    }
}
