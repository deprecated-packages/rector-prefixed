<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function getNode() : string;
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string;
}
