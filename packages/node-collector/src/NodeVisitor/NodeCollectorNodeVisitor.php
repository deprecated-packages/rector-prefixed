<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector;
final class NodeCollectorNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector $parsedClassConstFetchNodeCollector, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoperb75b35f52b74\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector $parsedPropertyFetchNodeCollector)
    {
        $this->nodeRepository = $nodeRepository;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->parsedPropertyFetchNodeCollector = $parsedPropertyFetchNodeCollector;
        $this->parsedClassConstFetchNodeCollector = $parsedClassConstFetchNodeCollector;
    }
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
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
