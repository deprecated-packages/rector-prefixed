<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use PhpParser\Node\Expr\Closure;
use PhpParser\NodeAbstract;
class InClosureNode extends \PhpParser\NodeAbstract implements \RectorPrefix20201227\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Expr\Closure */
    private $originalNode;
    public function __construct(\PhpParser\Node\Expr\Closure $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \PhpParser\Node\Expr\Closure
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
