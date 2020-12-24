<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
final class MatchPropertyTypeConflictingNameGuard extends \_PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireMatchPropertyTypeConflictingNameGuard(\_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
}
