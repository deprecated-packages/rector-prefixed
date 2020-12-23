<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings;
final class UnderscoreCamelCaseExpectedNameResolver extends \_PhpScoper0a2ac50786fa\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        $currentName = $this->nodeNameResolver->getName($node);
        if ($currentName === null) {
            return null;
        }
        return \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($currentName);
    }
}
