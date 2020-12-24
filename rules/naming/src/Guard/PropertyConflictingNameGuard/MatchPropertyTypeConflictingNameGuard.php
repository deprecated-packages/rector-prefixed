<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
final class MatchPropertyTypeConflictingNameGuard extends \_PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireMatchPropertyTypeConflictingNameGuard(\_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver $matchPropertyTypeExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $matchPropertyTypeExpectedNameResolver;
    }
}
