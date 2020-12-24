<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver;
final class BoolPropertyConflictingNameGuard extends \_PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireBoolPropertyConflictingNameGuard(\_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\BoolPropertyExpectedNameResolver $boolPropertyExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $boolPropertyExpectedNameResolver;
    }
}
