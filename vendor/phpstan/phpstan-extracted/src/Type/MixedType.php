<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyMethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class MixedType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType, \_PhpScoper0a2ac50786fa\PHPStan\Type\SubtractableType
{
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var bool */
    private $isExplicitMixed;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    public function __construct(bool $isExplicitMixed = \false, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
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
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOfMixed(\_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->subtractedType === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
        if ($isSuperType->yes()) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof self) {
            if ($type->subtractedType === null) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
            }
            $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
            if ($isSuperType->yes()) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->subtractedType->isSuperTypeOf($type)->negate();
    }
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType !== null && $this->subtractedType->isCallable()->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
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
    public function isSubTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self && !$otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateMixedType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($otherType);
            if ($isSuperType->yes()) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $isSuperType = $this->isSuperTypeOf($acceptingType);
        if ($isSuperType->no()) {
            return $isSuperType;
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
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
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        if ($this->subtractedType !== null && \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticTypeFactory::falsey()->equals($this->subtractedType)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([$this->toInteger(), $this->toFloat()]);
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
    }
    public function isExplicitMixed() : bool
    {
        return $this->isExplicitMixed;
    }
    public function subtract(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($type instanceof self && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($this->isExplicitMixed, $type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed);
    }
    public function changeSubtractedType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed, $subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['isExplicitMixed'], $properties['subtractedType'] ?? null);
    }
}
