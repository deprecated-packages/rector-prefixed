<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
class ClassStringType extends \_PhpScoperb75b35f52b74\PHPStan\Type\StringType
{
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'class-string';
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self();
    }
}
