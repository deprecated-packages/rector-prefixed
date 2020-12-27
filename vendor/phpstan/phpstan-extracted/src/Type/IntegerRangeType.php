<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
class IntegerRangeType extends \PHPStan\Type\IntegerType implements \PHPStan\Type\CompoundType
{
    /** @var int */
    private $min;
    /** @var int */
    private $max;
    private function __construct(?int $min, ?int $max)
    {
        \assert($min === null || $max === null || $min <= $max);
        $this->min = $min ?? \PHP_INT_MIN;
        $this->max = $max ?? \PHP_INT_MAX;
    }
    public static function fromInterval(?int $min, ?int $max, int $shift = 0) : \PHPStan\Type\Type
    {
        $min = $min ?? \PHP_INT_MIN;
        $max = $max ?? \PHP_INT_MAX;
        if ($shift !== 0) {
            if ($shift < 0) {
                if ($max < \PHP_INT_MIN - $shift) {
                    return new \PHPStan\Type\NeverType();
                }
                if ($max !== \PHP_INT_MAX) {
                    $max += $shift;
                }
                $min = $min < \PHP_INT_MIN - $shift ? \PHP_INT_MIN : $min + $shift;
            } else {
                if ($min > \PHP_INT_MAX - $shift) {
                    return new \PHPStan\Type\NeverType();
                }
                if ($min !== \PHP_INT_MIN) {
                    $min += $shift;
                }
                $max = $max > \PHP_INT_MAX - $shift ? \PHP_INT_MAX : $max + $shift;
            }
        }
        if ($min > $max) {
            return new \PHPStan\Type\NeverType();
        }
        if ($min === $max) {
            return new \PHPStan\Type\Constant\ConstantIntegerType($min);
        }
        if ($min === \PHP_INT_MIN && $max === \PHP_INT_MAX) {
            return new \PHPStan\Type\IntegerType();
        }
        return new self($min, $max);
    }
    public function getMin() : int
    {
        return $this->min;
    }
    public function getMax() : int
    {
        return $this->max;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        if ($this->min === \PHP_INT_MIN) {
            return \sprintf('int<min, %d>', $this->max);
        }
        if ($this->max === \PHP_INT_MAX) {
            return \sprintf('int<%d, max>', $this->min);
        }
        return \sprintf('int<%d, %d>', $this->min, $this->max);
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if ($this->min > $type->max || $this->max < $type->min) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            if ($this->min <= $type->min && $this->max >= $type->max) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            if ($this->min <= $type->getValue() && $type->getValue() <= $this->max) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            if ($this->min > $type->max || $this->max < $type->min) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            if ($this->min <= $type->min && $this->max >= $type->max) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            if ($this->min <= $type->getValue() && $type->getValue() <= $this->max) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            return \PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \PHPStan\TrinaryLogic
    {
        if ($otherType instanceof parent) {
            return $otherType->isSuperTypeOf($this);
        }
        if ($otherType instanceof \PHPStan\Type\UnionType || $otherType instanceof \PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->min === $type->min && $this->max === $type->max;
    }
    public function generalize() : \PHPStan\Type\Type
    {
        return new parent();
    }
    public function isSmallerThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::extremeIdentity((new \PHPStan\Type\Constant\ConstantIntegerType($this->min))->isSmallerThan($otherType, $orEqual), (new \PHPStan\Type\Constant\ConstantIntegerType($this->max))->isSmallerThan($otherType, $orEqual));
    }
    public function isGreaterThan(\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::extremeIdentity($otherType->isSmallerThan(new \PHPStan\Type\Constant\ConstantIntegerType($this->min), $orEqual), $otherType->isSmallerThan(new \PHPStan\Type\Constant\ConstantIntegerType($this->max), $orEqual));
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new parent();
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        $isZero = (new \PHPStan\Type\Constant\ConstantIntegerType(0))->isSuperTypeOf($this);
        if ($isZero->no()) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\true);
        }
        if ($isZero->maybe()) {
            return new \PHPStan\Type\BooleanType();
        }
        return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['min'], $properties['max']);
    }
}
