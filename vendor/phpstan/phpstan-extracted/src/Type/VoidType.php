<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\FalseyBooleanTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonCallableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonIterableTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonObjectTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonOffsetAccessibleTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class VoidType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
{
    use NonCallableTypeTrait;
    use NonIterableTypeTrait;
    use NonObjectTypeTrait;
    use NonOffsetAccessibleTypeTrait;
    use FalseyBooleanTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($type instanceof self);
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self;
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return 'void';
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self();
    }
}
