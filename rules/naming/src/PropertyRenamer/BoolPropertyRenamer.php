<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\PropertyRenamer;

use _PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard;
final class BoolPropertyRenamer extends \_PhpScoper0a2ac50786fa\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard $boolPropertyConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $boolPropertyConflictingNameGuard;
    }
}
