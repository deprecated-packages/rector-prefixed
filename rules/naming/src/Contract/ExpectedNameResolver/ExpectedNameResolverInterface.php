<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Contract\ExpectedNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
interface ExpectedNameResolverInterface
{
    /**
     * @param Param|Property $node
     */
    public function resolveIfNotYet(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string;
    /**
     * @param Param|Property $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string;
}
