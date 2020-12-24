<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PostRector\Collector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToReplaceCollector implements \_PhpScopere8e811afab72\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];
    public function addReplaceNodeWithAnotherNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node $replaceWith) : void
    {
        $this->nodesToReplace[] = [$node, $replaceWith];
    }
    public function isActive() : bool
    {
        return $this->nodesToReplace !== [];
    }
    /**
     * @return Node[][]
     */
    public function getNodes() : array
    {
        return $this->nodesToReplace;
    }
}
