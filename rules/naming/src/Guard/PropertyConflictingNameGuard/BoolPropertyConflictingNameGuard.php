<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
final class BoolPropertyConflictingNameGuard extends \_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireBoolPropertyConflictingNameGuard(\_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $boolPropertyExpectedNameResolver;
    }
}
