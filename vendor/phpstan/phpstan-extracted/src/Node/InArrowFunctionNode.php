<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
class InArrowFunctionNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\ArrowFunction */
    private $originalNode;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_InArrowFunctionNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
