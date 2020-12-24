<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
class ClassStringType extends \_PhpScoper0a6b37af0871\PHPStan\Type\StringType
{
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'class-string';
    }
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::getInstance();
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::getInstance();
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($broker->hasClass($type->getValue()));
        }
        if ($type instanceof self) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof parent) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self();
    }
}
