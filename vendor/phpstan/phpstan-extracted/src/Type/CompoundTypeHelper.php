<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
class CompoundTypeHelper
{
    public static function accepts(\_PhpScopere8e811afab72\PHPStan\Type\CompoundType $compoundType, \_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $compoundType->isAcceptedBy($otherType, $strictTypes);
    }
}
