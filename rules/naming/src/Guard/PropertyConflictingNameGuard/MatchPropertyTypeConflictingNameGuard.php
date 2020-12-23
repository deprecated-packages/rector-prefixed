<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
final class MatchPropertyTypeConflictingNameGuard extends \_PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireMatchPropertyTypeConflictingNameGuard(\_PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
}
