<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer;

use _PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard;
final class MatchTypePropertyRenamer extends \_PhpScoper0a6b37af0871\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard $matchPropertyTypeConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $matchPropertyTypeConflictingNameGuard;
    }
}
