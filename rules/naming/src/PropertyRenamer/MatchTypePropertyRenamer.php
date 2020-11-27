<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard;
final class MatchTypePropertyRenamer extends \Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\Rector\Naming\Guard\PropertyConflictingNameGuard\MatchPropertyTypeConflictingNameGuard $matchPropertyTypeConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $matchPropertyTypeConflictingNameGuard;
    }
}
