<?php

declare (strict_types=1);
namespace Rector\NodeNameResolver\Contract;

use PhpParser\Node;
interface NodeNameResolverInterface
{
    /**
     * @return class-string<Node>
     */
    public function getNode() : string;
    /**
     * @return string|null
     */
    public function resolve(\PhpParser\Node $node);
}
