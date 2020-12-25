<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\Dummy\DummyConstantReflection;
use PHPStan\Reflection\Dummy\DummyMethodReflection;
use PHPStan\Reflection\Dummy\DummyPropertyReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Traits\MaybeIterableTypeTrait;
use PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class MixedType implements \PHPStan\Type\CompoundType, \PHPStan\Type\SubtractableType
{
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var bool */
    private $isExplicitMixed;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    public function __construct(bool $isExplicitMixed = \false, ?\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->isExplicitMixed = $isExplicitMixed;
        $this->subtractedType = $subtractedType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOfMixed(\PHPStan\Type\MixedType $type) : \PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \PHPStan\TrinaryLogic::createYes();
                }
                return \PHPStan\TrinaryLogic::createMaybe();
            }
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type->subtractedType === null) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
        if ($isSuperType->yes()) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \PHPStan\TrinaryLogic::createYes();
                }
                return \PHPStan\TrinaryLogic::createMaybe();
            }
            return \PHPStan\TrinaryLogic::createYes();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null || $type instanceof \PHPStan\Type\NeverType) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof self) {
            if ($type->subtractedType === null) {
                return \PHPStan\TrinaryLogic::createMaybe();
            }
            $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
            if ($isSuperType->yes()) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->subtractedType->isSuperTypeOf($type)->negate();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        if ($this->subtractedType !== null && $this->subtractedType->isCallable()->yes()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if ($this->subtractedType === null) {
            if ($type->subtractedType === null) {
                return \true;
            }
            return \false;
        }
        if ($type->subtractedType === null) {
            return \false;
        }
        return $this->subtractedType->equals($type->subtractedType);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self && !$otherType instanceof \PHPStan\Type\Generic\TemplateMixedType) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($otherType);
            if ($isSuperType->yes()) {
                return \PHPStan\TrinaryLogic::createNo();
            }
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        $isSuperType = $this->isSuperTypeOf($acceptingType);
        if ($isSuperType->no()) {
            return $isSuperType;
        }
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        return new \PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'mixed';
        }, static function () : string {
            return 'mixed';
        }, function () use($level) : string {
            $description = 'mixed';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        }, function () use($level) : string {
            $description = 'mixed';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            if ($this->isExplicitMixed) {
                $description .= '=explicit';
            } else {
                $description .= '=implicit';
            }
            return $description;
        });
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        if ($this->subtractedType !== null && \PHPStan\Type\StaticTypeFactory::falsey()->equals($this->subtractedType)) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return new \PHPStan\Type\BooleanType();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\UnionType([$this->toInteger(), $this->toFloat()]);
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\IntegerType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\FloatType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\StringType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
    }
    public function isExplicitMixed() : bool
    {
        return $this->isExplicitMixed;
    }
    public function subtract(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if ($type instanceof self && !$type instanceof \PHPStan\Type\Generic\TemplateType) {
            return new \PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($this->isExplicitMixed, $type);
    }
    public function getTypeWithoutSubtractedType() : \PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed);
    }
    public function changeSubtractedType(?\PHPStan\Type\Type $subtractedType) : \PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed, $subtractedType);
    }
    public function getSubtractedType() : ?\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['isExplicitMixed'], $properties['subtractedType'] ?? null);
    }
}
