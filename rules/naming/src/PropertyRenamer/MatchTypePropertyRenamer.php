<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\PropertyRenamer;

use _PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard;
final class MatchTypePropertyRenamer extends \_PhpScoper0a2ac50786fa\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard $matchPropertyTypeConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $matchPropertyTypeConflictingNameGuard;
    }
}
