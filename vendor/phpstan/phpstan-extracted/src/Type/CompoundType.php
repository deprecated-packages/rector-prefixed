<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
interface CompoundType extends \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
    public function isGreaterThan(\_PhpScopere8e811afab72\PHPStan\Type\Type $otherType, bool $orEqual = \false) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic;
}
