<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\Contract;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
interface NodeTraversableInterface
{
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void;
}
