<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer;

use _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard;
final class UnderscoreCamelCasePropertyRenamer extends \_PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard $underscoreCamelCaseConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $underscoreCamelCaseConflictingNameGuard;
    }
}
