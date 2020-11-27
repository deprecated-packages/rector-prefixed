<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantStringType;
class ClassStringType extends \PHPStan\Type\StringType
{
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'class-string';
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $broker = \PHPStan\Broker\Broker::getInstance();
            return \PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\StringType) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $broker = \PHPStan\Broker\Broker::getInstance();
            return \PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self();
    }
}
