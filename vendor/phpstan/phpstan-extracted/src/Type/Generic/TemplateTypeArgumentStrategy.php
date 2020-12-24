<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
/**
 * Template type strategy suitable for return type acceptance contexts
 */
class TemplateTypeArgumentStrategy implements \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType $left, \_PhpScopere8e811afab72\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            foreach ($right->getTypes() as $type) {
                if ($this->accepts($left, $type, $strictTypes)->yes()) {
                    return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
                }
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($left->equals($right))->or(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($right->equals(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType())));
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
