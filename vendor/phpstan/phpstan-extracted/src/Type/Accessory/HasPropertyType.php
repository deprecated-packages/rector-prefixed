<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Accessory;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\ObjectTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class HasPropertyType implements \_PhpScopere8e811afab72\PHPStan\Type\Accessory\AccessoryType, \_PhpScopere8e811afab72\PHPStan\Type\CompoundType
{
    use ObjectTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var string */
    private $propertyName;
    public function __construct(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function getPropertyName() : string
    {
        return $this->propertyName;
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($this->equals($type));
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $type->hasProperty($this->propertyName);
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $otherType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        if ($otherType instanceof self) {
            $limit = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->hasProperty($this->propertyName));
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->propertyName === $type->propertyName;
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasProperty(%s)', $this->propertyName);
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->propertyName === $propertyName) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['propertyName']);
    }
}
