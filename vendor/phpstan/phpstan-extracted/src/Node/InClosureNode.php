<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\NodeAbstract;
class InClosureNode extends \_PhpScoperb75b35f52b74\PhpParser\NodeAbstract implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\Closure */
    private $originalNode;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_InClosureNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
