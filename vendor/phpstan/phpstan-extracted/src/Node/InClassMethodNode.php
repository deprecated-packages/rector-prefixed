<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

class InClassMethodNode extends \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Stmt\ClassMethod */
    private $originalNode;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
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