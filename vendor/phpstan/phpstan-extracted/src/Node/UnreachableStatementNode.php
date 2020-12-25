<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Stmt;
class UnreachableStatementNode extends \PhpParser\Node\Stmt implements \PHPStan\Node\VirtualNode
{
    /** @var Stmt */
    private $originalStatement;
    public function __construct(\PhpParser\Node\Stmt $originalStatement)
    {
        parent::__construct($originalStatement->getAttributes());
        $this->originalStatement = $originalStatement;
    }
    public function getOriginalStatement() : \PhpParser\Node\Stmt
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
