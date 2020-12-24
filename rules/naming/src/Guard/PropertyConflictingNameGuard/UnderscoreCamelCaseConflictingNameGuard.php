<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
final class UnderscoreCamelCaseConflictingNameGuard extends \_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireUnderscoreCamelCaseConflictingNameGuard(\_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
    }
}
