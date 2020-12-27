<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\NodeAbstract;
class InArrowFunctionNode extends \PhpParser\NodeAbstract implements \PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\ArrowFunction */
    private $originalNode;
    public function __construct(\PhpParser\Node\Expr\ArrowFunction $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \PhpParser\Node\Expr\ArrowFunction
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
