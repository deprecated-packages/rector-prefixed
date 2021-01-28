<?php

declare (strict_types=1);
namespace Rector\PostRector\Rector;

use PhpParser\Node;
use Rector\PostRector\Collector\NodesToReplaceCollector;
final class NodeToReplacePostRector extends \Rector\PostRector\Rector\AbstractPostRector
{
    /**
     * @var NodesToReplaceCollector
     */
    private $nodesToReplaceCollector;
    public function __construct(\Rector\PostRector\Collector\NodesToReplaceCollector $nodesToReplaceCollector)
    {
        $this->nodesToReplaceCollector = $nodesToReplaceCollector;
    }
    public function getPriority() : int
    {
        return 1100;
    }
    public function leaveNode(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->nodesToReplaceCollector->getNodes() as [$nodeToFind, $replacement]) {
            if ($node === $nodeToFind) {
                return $replacement;
            }
        }
        return null;
    }
}
