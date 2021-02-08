<?php

declare (strict_types=1);
namespace Rector\PostRector\Rector;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Rector\PostRector\Collector\NodesToReplaceCollector;
use Rector\PostRector\Contract\Rector\PostRectorInterface;
final class NodeToReplacePostRector extends \PhpParser\NodeVisitorAbstract implements \Rector\PostRector\Contract\Rector\PostRectorInterface
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
