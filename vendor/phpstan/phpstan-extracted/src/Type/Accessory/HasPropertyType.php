<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Accessory;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\ObjectTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
class HasPropertyType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\AccessoryType, \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType
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
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($this->equals($type));
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $type->hasProperty($this->propertyName);
    }
    public function isSubTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $otherType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $otherType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        if ($otherType instanceof self) {
            $limit = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->hasProperty($this->propertyName));
    }
    public function isAcceptedBy(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->propertyName === $type->propertyName;
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasProperty(%s)', $this->propertyName);
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->propertyName === $propertyName) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['propertyName']);
    }
}
