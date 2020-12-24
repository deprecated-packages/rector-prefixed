<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Collector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToReplaceCollector implements \_PhpScoper0a6b37af0871\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];
    public function addReplaceNodeWithAnotherNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node $replaceWith) : void
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
