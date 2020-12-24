<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Collector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
final class NodesToReplaceCollector implements \_PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];
    public function addReplaceNodeWithAnotherNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node $replaceWith) : void
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
