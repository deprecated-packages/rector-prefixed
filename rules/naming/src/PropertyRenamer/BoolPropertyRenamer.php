<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\PropertyRenamer;

use _PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard;
final class BoolPropertyRenamer extends \_PhpScopere8e811afab72\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard $boolPropertyConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $boolPropertyConflictingNameGuard;
    }
}
