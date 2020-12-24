<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a6b37af0871\PhpParser\NodeAbstract;
class InArrowFunctionNode extends \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract implements \_PhpScoper0a6b37af0871\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\ArrowFunction */
    private $originalNode;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction
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
