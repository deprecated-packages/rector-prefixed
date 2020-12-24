<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
final class MatchPropertyTypeConflictingNameGuard extends \_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireMatchPropertyTypeConflictingNameGuard(\_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
}
