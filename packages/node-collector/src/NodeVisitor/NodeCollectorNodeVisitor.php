<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeVisitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector;
final class NodeCollectorNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedClassConstFetchNodeCollector $parsedClassConstFetchNodeCollector, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeCollector\ParsedPropertyFetchNodeCollector $parsedPropertyFetchNodeCollector)
    {
        $this->nodeRepository = $nodeRepository;
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->parsedPropertyFetchNodeCollector = $parsedPropertyFetchNodeCollector;
        $this->parsedClassConstFetchNodeCollector = $parsedClassConstFetchNodeCollector;
    }
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
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
