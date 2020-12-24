<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings;
final class UnderscoreCamelCaseExpectedNameResolver extends \_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $currentName = $this->nodeNameResolver->getName($node);
        if ($currentName === null) {
            return null;
        }
        return \_PhpScoperb75b35f52b74\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($currentName);
    }
}
