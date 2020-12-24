<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
class FileNode extends \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
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
