<?php

declare (strict_types=1);
namespace Rector\Naming\Guard\PropertyConflictingNameGuard;

use Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
final class MatchPropertyTypeConflictingNameGuard extends \Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireMatchPropertyTypeConflictingNameGuard(\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
}
