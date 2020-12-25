<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard;
final class BoolPropertyRenamer extends \Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\Rector\Naming\Guard\PropertyConflictingNameGuard\BoolPropertyConflictingNameGuard $boolPropertyConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $boolPropertyConflictingNameGuard;
    }
}
