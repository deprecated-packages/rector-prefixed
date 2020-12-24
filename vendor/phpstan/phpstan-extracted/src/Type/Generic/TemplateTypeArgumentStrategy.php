<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType())));
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
