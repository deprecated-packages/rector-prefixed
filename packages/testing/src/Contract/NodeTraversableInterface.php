<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\Contract;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
interface NodeTraversableInterface
{
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void;
}
