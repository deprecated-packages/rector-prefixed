<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
class InArrowFunctionNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\ArrowFunction */
    private $originalNode;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrowFunction $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrowFunction
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
