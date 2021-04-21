<?php

declare(strict_types=1);

namespace Rector\PostRector\Collector;

use PhpParser\Node;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;

final class NodesToReplaceCollector implements NodeCollectorInterface
{
    /**
     * @var Node[][]
     */
    private $nodesToReplace = [];

    /**
     * @return void
     */
    public function addReplaceNodeWithAnotherNode(Node $node, Node $replaceWith)
    {
        $this->nodesToReplace[] = [$node, $replaceWith];
    }

    public function isActive(): bool
    {
        return $this->nodesToReplace !== [];
    }

    /**
     * @return Node[][]
     */
    public function getNodes(): array
    {
        return $this->nodesToReplace;
    }
}
