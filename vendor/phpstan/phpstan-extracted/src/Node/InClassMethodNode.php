<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

class InClassMethodNode extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Stmt\ClassMethod */
    private $originalNode;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        return $this->originalNode;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_InClassMethodNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
