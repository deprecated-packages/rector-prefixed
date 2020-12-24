<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings;
final class UnderscoreCamelCaseExpectedNameResolver extends \_PhpScoper0a6b37af0871\Rector\Naming\ExpectedNameResolver\AbstractExpectedNameResolver
{
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        $currentName = $this->nodeNameResolver->getName($node);
        if ($currentName === null) {
            return null;
        }
        return \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::underscoreToCamelCase($currentName);
    }
}
