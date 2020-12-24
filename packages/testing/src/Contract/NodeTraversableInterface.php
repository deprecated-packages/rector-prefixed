<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\Contract;

use _PhpScopere8e811afab72\PhpParser\Node;
interface NodeTraversableInterface
{
    /**
     * @param Node[] $nodes
     */
    public function traverseNodes(array $nodes) : void;
}
