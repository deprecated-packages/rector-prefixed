<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
class ClassStringType extends \_PhpScopere8e811afab72\PHPStan\Type\StringType
{
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'class-string';
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self();
    }
}
