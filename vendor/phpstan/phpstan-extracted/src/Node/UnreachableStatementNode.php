<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
class UnreachableStatementNode extends \_PhpScopere8e811afab72\PhpParser\Node\Stmt implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var Stmt */
    private $originalStatement;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $originalStatement)
    {
        parent::__construct($originalStatement->getAttributes());
        $this->originalStatement = $originalStatement;
    }
    public function getOriginalStatement() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt
    {
        return $this->originalStatement;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_UnreachableStatementNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
