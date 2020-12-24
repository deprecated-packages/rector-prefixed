<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\NodeAbstract;
class FileNode extends \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract implements \_PhpScoper0a6b37af0871\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node[] */
    private $nodes;
    /**
     * @param \PhpParser\Node[] $nodes
     */
    public function __construct(array $nodes)
    {
        $firstNode = $nodes[0] ?? null;
        parent::__construct($firstNode !== null ? $firstNode->getAttributes() : []);
        $this->nodes = $nodes;
    }
    /**
     * @return \PhpParser\Node[]
     */
    public function getNodes() : array
    {
        return $this->nodes;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_FileNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
