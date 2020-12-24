<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyConstantReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeIterableTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\MaybeOffsetAccessibleTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
class MixedType implements \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType, \_PhpScoperb75b35f52b74\PHPStan\Type\SubtractableType
{
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var bool */
    private $isExplicitMixed;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    public function __construct(bool $isExplicitMixed = \false, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
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
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function isSuperTypeOfMixed(\_PhpScoperb75b35f52b74\PHPStan\Type\MixedType $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->subtractedType === null) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
        if ($isSuperType->yes()) {
            if ($this->isExplicitMixed) {
                if ($type->isExplicitMixed) {
                    return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
                }
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType === null || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof self) {
            if ($type->subtractedType === null) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
            if ($isSuperType->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->subtractedType->isSuperTypeOf($type)->negate();
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($this->subtractedType !== null && $this->subtractedType->isCallable()->yes()) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
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
    public function isSubTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $otherType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof self && !$otherType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($otherType);
            if ($isSuperType->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
            }
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        $isSuperType = $this->isSuperTypeOf($acceptingType);
        if ($isSuperType->no()) {
            return $isSuperType;
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function canAccessProperties() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function getProperty(string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyPropertyReflection();
    }
    public function canCallMethods() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function getMethod(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
    }
    public function canAccessConstants() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function getConstant(string $constantName) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ConstantReflection
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
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
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType
    {
        if ($this->subtractedType !== null && \_PhpScoperb75b35f52b74\PHPStan\Type\StaticTypeFactory::falsey()->equals($this->subtractedType)) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([$this->toInteger(), $this->toFloat()]);
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType();
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType();
    }
    public function toString() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
    }
    public function toArray() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
    }
    public function isExplicitMixed() : bool
    {
        return $this->isExplicitMixed;
    }
    public function subtract(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($type instanceof self && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($this->isExplicitMixed, $type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed);
    }
    public function changeSubtractedType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($this->isExplicitMixed, $subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function isArray() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['isExplicitMixed'], $properties['subtractedType'] ?? null);
    }
}
