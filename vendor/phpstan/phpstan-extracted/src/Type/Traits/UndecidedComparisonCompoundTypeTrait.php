<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Traits;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
trait UndecidedComparisonCompoundTypeTrait
{
    use UndecidedComparisonTypeTrait;
    public function isGreaterThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
}
