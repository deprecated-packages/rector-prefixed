<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

class InFunctionNode extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Stmt\Function_ */
    private $originalNode;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_ $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_InFunctionNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
