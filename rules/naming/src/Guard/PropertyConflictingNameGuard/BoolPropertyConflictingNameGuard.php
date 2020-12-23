<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
final class BoolPropertyConflictingNameGuard extends \_PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireBoolPropertyConflictingNameGuard(\_PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $boolPropertyExpectedNameResolver;
    }
}
