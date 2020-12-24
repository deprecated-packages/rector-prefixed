<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard;

use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver;
final class UnderscoreCamelCaseConflictingNameGuard extends \_PhpScoperb75b35f52b74\Rector\Naming\Guard\PropertyConflictingNameGuard\AbstractPropertyConflictingNameGuard
{
    /**
     * @required
     */
    public function autowireUnderscoreCamelCaseConflictingNameGuard(\_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\UnderscoreCamelCaseExpectedNameResolver $underscoreCamelCaseExpectedNameResolver) : void
    {
        $this->expectedNameResolver = $underscoreCamelCaseExpectedNameResolver;
    }
}
