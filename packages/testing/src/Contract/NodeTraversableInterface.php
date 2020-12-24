<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\Contract;

use _PhpScoperb75b35f52b74\PhpParser\Node;
interface NodeTraversableInterface
{
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void;
}
