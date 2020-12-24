<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
class LiteralArrayNode extends \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var LiteralArrayItem[] */
    private $itemNodes;
    /**
     * @param Array_ $originalNode
     * @param LiteralArrayItem[] $itemNodes
     */
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ $originalNode, array $itemNodes)
    {
        parent::__construct($originalNode->getAttributes());
        $this->itemNodes = $itemNodes;
    }
    /**
     * @return LiteralArrayItem[]
     */
    public function getItemNodes() : array
    {
        return $this->itemNodes;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_LiteralArray';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
