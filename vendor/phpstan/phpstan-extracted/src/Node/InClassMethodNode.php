<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

class InClassMethodNode extends \_PhpScopere8e811afab72\PhpParser\Node\Stmt implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var \PhpParser\Node\Stmt\ClassMethod */
    private $originalNode;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $originalNode)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
    }
    public function getOriginalNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
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
