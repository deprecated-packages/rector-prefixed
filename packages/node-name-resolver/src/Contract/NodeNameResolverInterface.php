<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeNameResolver\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function getNode() : string;
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string;
}
