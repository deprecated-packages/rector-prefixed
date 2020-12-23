<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Type\UnionTypeMethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance;
class UnionType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $throwException = static function () use($types) : void {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('Cannot create %s with: %s', self::class, \implode(', ', \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : string {
                return $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value());
            }, $types))));
        };
        if (\count($types) < 2) {
            $throwException();
        }
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
                continue;
            }
            $throwException();
        }
        $this->types = \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionTypeHelper::sortTypes($types);
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
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->getTypes());
    }
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->accepts($type, $strictTypes);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IterableType) {
            return $otherType->isSubTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSubTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function isAcceptedBy(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
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
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        $joinTypes = static function (array $types) use($level) : string {
            $typeNames = [];
            foreach ($types as $type) {
                if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableType) {
                    $typeNames[] = \sprintf('(%s)', $type->describe($level));
                } elseif ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
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
            $types = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
                if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantType && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType) {
                    return $type->generalize();
                }
                return $type;
            }, $this->types));
            if ($types instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
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
    private function hasInternal(callable $canCallback, callable $hasCallback) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->types as $type) {
            if ($canCallback($type)->no()) {
                $results[] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
                continue;
            }
            $results[] = $hasCallback($type);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...$results);
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
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        return $object;
    }
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        return $this->getInternal(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        }, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($propertyName, $scope) : PropertyReflection {
            return $type->getProperty($propertyName, $scope);
        });
    }
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
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
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Type\UnionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->hasInternal(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        }, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection
    {
        return $this->getInternal(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        }, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($constantName) : ConstantReflection {
            return $type->getConstant($constantName);
        });
    }
    public function isIterable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $types = [];
        foreach ($this->types as $innerType) {
            $valueType = $innerType->getOffsetValueType($offsetType);
            if ($valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                continue;
            }
            $types[] = $valueType;
        }
        if (\count($types) === 0) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        foreach ($this->types as $type) {
            if ($type->isCallable()->no()) {
                continue;
            }
            return $type->getCallableParametersAcceptors($scope);
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        /** @var BooleanType $type */
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        return $type;
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $templateType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($templateType->inferTemplateTypes($type));
        }
        return $types;
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $references = [];
        foreach ($this->types as $type) {
            foreach ($type->getReferencedTemplateTypes($positionVariance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
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
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['types']);
    }
    /**
     * @param callable(Type $type): TrinaryLogic $getResult
     * @return TrinaryLogic
     */
    private function unionResults(callable $getResult) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...\array_map($getResult, $this->types));
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    protected function unionTypes(callable $getType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...\array_map($getType, $this->types));
    }
}
