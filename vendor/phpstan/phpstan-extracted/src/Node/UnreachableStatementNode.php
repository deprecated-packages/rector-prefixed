<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
class UnreachableStatementNode extends \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var Stmt */
    private $originalStatement;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $originalStatement)
    {
        parent::__construct($originalStatement->getAttributes());
        $this->originalStatement = $originalStatement;
    }
    public function getOriginalStatement() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
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
