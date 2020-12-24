<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer;

use _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard;
final class BoolPropertyRenamer extends \_PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard $boolPropertyConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $boolPropertyConflictingNameGuard;
    }
}
