<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeCollector\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector;
final class NodeCollectorNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var ParsedPropertyFetchNodeCollector
     */
    private $parsedPropertyFetchNodeCollector;
    /**
     * @var ParsedClassConstFetchNodeCollector
     */
    private $parsedClassConstFetchNodeCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector $parsedClassConstFetchNodeCollector, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector $parsedPropertyFetchNodeCollector)
    {
        $this->nodeRepository = $nodeRepository;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->parsedPropertyFetchNodeCollector = $parsedPropertyFetchNodeCollector;
        $this->parsedClassConstFetchNodeCollector = $parsedClassConstFetchNodeCollector;
    }
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        if ($this->parsedNodeCollector->isCollectableNode($node)) {
            $this->parsedNodeCollector->collect($node);
        }
        $this->nodeRepository->collect($node);
        $this->parsedPropertyFetchNodeCollector->collect($node);
        $this->parsedClassConstFetchNodeCollector->collect($node);
        return null;
    }
}
