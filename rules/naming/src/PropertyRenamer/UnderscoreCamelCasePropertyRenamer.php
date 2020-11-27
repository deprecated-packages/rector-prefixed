<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard;
final class UnderscoreCamelCasePropertyRenamer extends \Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard $underscoreCamelCaseConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $underscoreCamelCaseConflictingNameGuard;
    }
}
