<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PostRector\Collector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToReplaceCollector implements \_PhpScoper0a2ac50786fa\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];
    public function addReplaceNodeWithAnotherNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node $replaceWith) : void
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
