<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\NodeAbstract;
class LiteralArrayNode extends \_PhpScoper0a2ac50786fa\PhpParser\NodeAbstract implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var LiteralArrayItem[] */
    private $itemNodes;
    /**
     * @param Array_ $originalNode
     * @param LiteralArrayItem[] $itemNodes
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $originalNode, array $itemNodes)
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
