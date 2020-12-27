<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\Type\UnionTypeMethodReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
class UnionType implements \PHPStan\Type\CompoundType
{
    /** @var \PHPStan\Type\Type[] */
    private $types;
    /**
     * @param Type[] $types
     */
    public function __construct(array $types)
    {
        $throwException = static function () use($types) : void {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('Cannot create %s with: %s', self::class, \implode(', ', \array_map(static function (\PHPStan\Type\Type $type) : string {
                return $type->describe(\PHPStan\Type\VerbosityLevel::value());
            }, $types))));
        };
        if (\count($types) < 2) {
            $throwException();
        }
        foreach ($types as $type) {
            if (!$type instanceof \PHPStan\Type\UnionType) {
                continue;
            }
            $throwException();
        }
        $this->types = \PHPStan\Type\UnionTypeHelper::sortTypes($types);
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
        return \PHPStan\Type\UnionTypeHelper::getReferencedClasses($this->getTypes());
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType && !$type instanceof \PHPStan\Type\CallableType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->accepts($type, $strictTypes);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $otherType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self || $otherType instanceof \PHPStan\Type\IterableType) {
            return $otherType->isSubTypeOf($this);
        }
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $innerType->isSuperTypeOf($otherType);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo()->or(...$results);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $otherType->isSuperTypeOf($innerType);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->getTypes() as $innerType) {
            $results[] = $acceptingType->accepts($innerType, $strictTypes);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::extremeIdentity(...$results);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
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
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        $joinTypes = static function (array $types) use($level) : string {
            $typeNames = [];
            foreach ($types as $type) {
                if ($type instanceof \PHPStan\Type\ClosureType || $type instanceof \PHPStan\Type\CallableType) {
                    $typeNames[] = \sprintf('(%s)', $type->describe($level));
                } elseif ($type instanceof \PHPStan\Type\IntersectionType) {
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
            $types = \PHPStan\Type\TypeCombinator::union(...\array_map(static function (\PHPStan\Type\Type $type) : Type {
                if ($type instanceof \PHPStan\Type\ConstantType && !$type instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
                    return $type->generalize();
                }
                return $type;
            }, $this->types));
            if ($types instanceof \PHPStan\Type\UnionType) {
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
    private function hasInternal(callable $canCallback, callable $hasCallback) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $results = [];
        foreach ($this->types as $type) {
            if ($canCallback($type)->no()) {
                $results[] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
                continue;
            }
            $results[] = $hasCallback($type);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::extremeIdentity(...$results);
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
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return $object;
    }
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessProperties();
        });
    }
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        });
    }
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        return $this->getInternal(static function (\PHPStan\Type\Type $type) use($propertyName) : TrinaryLogic {
            return $type->hasProperty($propertyName);
        }, static function (\PHPStan\Type\Type $type) use($propertyName, $scope) : PropertyReflection {
            return $type->getProperty($propertyName, $scope);
        });
    }
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canCallMethods();
        });
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) use($methodName) : TrinaryLogic {
            return $type->hasMethod($methodName);
        });
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
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
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        if ($methodsCount === 1) {
            return $methods[0];
        }
        return new \RectorPrefix20201227\PHPStan\Reflection\Type\UnionTypeMethodReflection($methodName, $methods);
    }
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        });
    }
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->hasInternal(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->canAccessConstants();
        }, static function (\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        });
    }
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
    {
        return $this->getInternal(static function (\PHPStan\Type\Type $type) use($constantName) : TrinaryLogic {
            return $type->hasConstant($constantName);
        }, static function (\PHPStan\Type\Type $type) use($constantName) : ConstantReflection {
            return $type->getConstant($constantName);
        });
    }
    public function isIterable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterable();
        });
    }
    public function isIterableAtLeastOnce() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isIterableAtLeastOnce();
        });
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->getIterableKeyType();
        });
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->getIterableValueType();
        });
    }
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isArray();
        });
    }
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isNumericString();
        });
    }
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isOffsetAccessible();
        });
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) use($offsetType) : TrinaryLogic {
            return $type->hasOffsetValueType($offsetType);
        });
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        $types = [];
        foreach ($this->types as $innerType) {
            $valueType = $innerType->getOffsetValueType($offsetType);
            if ($valueType instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            $types[] = $valueType;
        }
        if (\count($types) === 0) {
            return new \PHPStan\Type\ErrorType();
        }
        return \PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return $this->unionTypes(static function (\PHPStan\Type\Type $type) use($offsetType, $valueType) : Type {
            return $type->setOffsetValueType($offsetType, $valueType);
        });
    }
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCallable();
        });
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        foreach ($this->types as $type) {
            if ($type->isCallable()->no()) {
                continue;
            }
            return $type->getCallableParametersAcceptors($scope);
        }
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) : TrinaryLogic {
            return $type->isCloneable();
        });
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $type->isSmallerThan($otherType, $orEqual);
        });
    }
    public function isGreaterThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->unionResults(static function (\PHPStan\Type\Type $type) use($otherType, $orEqual) : TrinaryLogic {
            return $otherType->isSmallerThan($type, $orEqual);
        });
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        /** @var BooleanType $type */
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : BooleanType {
            return $type->toBoolean();
        });
        return $type;
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toNumber();
        });
        return $type;
    }
    public function toString() : \PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toString();
        });
        return $type;
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toInteger();
        });
        return $type;
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toFloat();
        });
        return $type;
    }
    public function toArray() : \PHPStan\Type\Type
    {
        $type = $this->unionTypes(static function (\PHPStan\Type\Type $type) : Type {
            return $type->toArray();
        });
        return $type;
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($type->inferTemplateTypes($receivedType));
        }
        return $types;
    }
    public function inferTemplateTypesOn(\PHPStan\Type\Type $templateType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $types = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->types as $type) {
            $types = $types->union($templateType->inferTemplateTypes($type));
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
            return \PHPStan\Type\TypeCombinator::union(...$types);
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
    private function unionResults(callable $getResult) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::extremeIdentity(...\array_map($getResult, $this->types));
    }
    /**
     * @param callable(Type $type): Type $getType
     * @return Type
     */
    protected function unionTypes(callable $getType) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeCombinator::union(...\array_map($getType, $this->types));
    }
}
