<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToReplaceCollector implements \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];
    public function addReplaceNodeWithAnotherNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $replaceWith) : void
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
