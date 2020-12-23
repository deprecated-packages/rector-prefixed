<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\ObjectTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectWithoutClassType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\SubtractableType
{
    use ObjectTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    public function __construct(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType = null)
    {
        if ($subtractedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->subtractedType = $subtractedType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [];
    }
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($type instanceof self || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName);
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof self) {
            if ($this->subtractedType === null) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
            }
            if ($type->subtractedType !== null) {
                $isSuperType = $type->subtractedType->isSuperTypeOf($this->subtractedType);
                if ($isSuperType->yes()) {
                    return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            if ($this->subtractedType === null) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
            }
            return $this->subtractedType->isSuperTypeOf($type)->negate();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
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
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'object';
        }, static function () : string {
            return 'object';
        }, function () use($level) : string {
            $description = 'object';
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        });
    }
    public function subtract(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($type instanceof self) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType();
        }
        if ($this->subtractedType !== null) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return new self($type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self();
    }
    public function changeSubtractedType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($subtractedType);
        }
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['subtractedType'] ?? null);
    }
}
