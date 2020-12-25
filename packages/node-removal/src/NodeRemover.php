<?php

declare (strict_types=1);
namespace Rector\NodeRemoval;

use PhpParser\Node;
use Rector\ChangesReporting\Collector\RectorChangeCollector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Collector\NodesToRemoveCollector;
final class NodeRemover
{
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var RectorChangeCollector
     */
    private $rectorChangeCollector;
    public function __construct(\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector, \Rector\ChangesReporting\Collector\RectorChangeCollector $rectorChangeCollector)
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->rectorChangeCollector = $rectorChangeCollector;
    }
    public function removeNode(\PhpParser\Node $node) : void
    {
        // this make sure to keep just added nodes, e.g. added class constant, that doesn't have analysis of full code in this run
        // if this is missing, there are false positive e.g. for unused private constant
        $isJustAddedNode = !(bool) $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        if ($isJustAddedNode) {
            return;
        }
        $this->nodesToRemoveCollector->addNodeToRemove($node);
        $this->rectorChangeCollector->notifyNodeFileInfo($node);
    }
}
