<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantStringType;
class ClassStringType extends \PHPStan\Type\StringType
{
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'class-string';
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \PHPStan\Type\StringType) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
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
