<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
final class UnderscoreCamelCaseExpectedNameResolver extends \_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?string
    {
        $currentName = $this->nodeNameResolver->getName($node);
        if ($currentName === null) {
            return null;
        }
        return \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($currentName);
    }
}
