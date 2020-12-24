<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
final class UnderscoreCamelCaseConflictingNameGuard extends \_PhpScopere8e811afab72\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireUnderscoreCamelCaseConflictingNameGuard(\_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
    }
}
