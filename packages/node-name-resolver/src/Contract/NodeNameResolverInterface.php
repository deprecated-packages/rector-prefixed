<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function getNode() : string;
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string;
}
