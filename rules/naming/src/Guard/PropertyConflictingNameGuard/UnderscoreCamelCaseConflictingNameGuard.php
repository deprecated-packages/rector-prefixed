<?php

declare (strict_types=1);
namespace Rector\Naming\Guard\PropertyConflictingNameGuard;

use Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
final class UnderscoreCamelCaseConflictingNameGuard extends \Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireUnderscoreCamelCaseConflictingNameGuard(\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
    }
}
