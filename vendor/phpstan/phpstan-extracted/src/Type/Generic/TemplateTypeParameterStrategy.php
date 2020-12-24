<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
/**
 * Template type strategy suitable for parameter type acceptance contexts
 */
class TemplateTypeParameterStrategy implements \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeStrategy
{
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType $left, \_PhpScopere8e811afab72\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($right instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($right, $left, $strictTypes);
        }
        return $left->getBound()->accepts($right, $strictTypes);
    }
    public function isArgument() : bool
    {
        return \false;
    }
    /**
     * @param mixed[] $properties
     */
    public static function __set_state(array $properties) : self
    {
        return new self();
    }
}
