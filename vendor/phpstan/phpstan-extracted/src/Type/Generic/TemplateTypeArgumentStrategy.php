<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Generic;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType())));
    }
    public function isArgument() : bool
    {
        return \true;
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self();
    }
}
