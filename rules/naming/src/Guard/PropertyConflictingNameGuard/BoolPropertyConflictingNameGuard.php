<?php

declare (strict_types=1);
namespace Rector\Naming\Guard\PropertyConflictingNameGuard;

use Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
final class BoolPropertyConflictingNameGuard extends \Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireBoolPropertyConflictingNameGuard(\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $boolPropertyExpectedNameResolver;
    }
}
