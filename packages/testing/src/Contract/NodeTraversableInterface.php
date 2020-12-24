<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\Contract;

use _PhpScoper0a6b37af0871\PhpParser\Node;
interface NodeTraversableInterface
{
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void;
}
