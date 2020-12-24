<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType())));
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
