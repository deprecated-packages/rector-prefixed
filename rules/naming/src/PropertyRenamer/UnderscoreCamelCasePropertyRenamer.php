<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\PropertyRenamer;

use _PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard;
final class UnderscoreCamelCasePropertyRenamer extends \_PhpScoperb75b35f52b74\Rector\Naming\PropertyRenamer\AbstractPropertyRenamer
{
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard\UnderscoreCamelCaseConflictingNameGuard $underscoreCamelCaseConflictingNameGuard)
    {
        $this->conflictingPropertyNameGuard = $underscoreCamelCaseConflictingNameGuard;
    }
}
