<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
final class BoolPropertyConflictingNameGuard extends \_PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireBoolPropertyConflictingNameGuard(\_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $boolPropertyExpectedNameResolver;
    }
}
