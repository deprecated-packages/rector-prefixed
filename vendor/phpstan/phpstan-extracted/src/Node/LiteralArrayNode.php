<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
class LiteralArrayNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\VirtualNode
{
    /** @var LiteralArrayItem[] */
    private $itemNodes;
    /**
     * @param Array_ $originalNode
     * @param LiteralArrayItem[] $itemNodes
     */
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ $originalNode, array $itemNodes)
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
