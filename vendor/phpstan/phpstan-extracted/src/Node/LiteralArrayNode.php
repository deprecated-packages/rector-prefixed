<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
class LiteralArrayNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var LiteralArrayItem[] */
    private $itemNodes;
    /**
     * @param Array_ $originalNode
     * @param LiteralArrayItem[] $itemNodes
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_ $originalNode, array $itemNodes)
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
