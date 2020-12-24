<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
class StatementOrderVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
{
    /** @var int[] */
    private $orderStack = [];
    /** @var int[] */
    private $expressionOrderStack = [];
    /** @var int */
    private $depth = 0;
    /** @var int */
    private $expressionDepth = 0;
    /**
     * @param Node[] $nodes $nodes
     * @return null
     */
    public function beforeTraverse(array $nodes)
    {
        $this->orderStack = [0];
        $this->depth = 0;
        return null;
    }
    /**
     * @param Node $node
     * @return null
     */
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        $order = $this->orderStack[\count($this->orderStack) - 1];
        $node->setAttribute('statementOrder', $order);
        $node->setAttribute('statementDepth', $this->depth);
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr && \count($this->expressionOrderStack) > 0) {
            $expressionOrder = $this->expressionOrderStack[\count($this->expressionOrderStack) - 1];
            $node->setAttribute('expressionOrder', $expressionOrder);
            $node->setAttribute('expressionDepth', $this->expressionDepth);
            $this->expressionOrderStack[\count($this->expressionOrderStack) - 1] = $expressionOrder + 1;
            $this->expressionOrderStack[] = 0;
            $this->expressionDepth++;
        }
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt) {
            return null;
        }
        $this->orderStack[\count($this->orderStack) - 1] = $order + 1;
        $this->orderStack[] = 0;
        $this->depth++;
        $this->expressionOrderStack = [0];
        $this->expressionDepth = 0;
        return null;
    }
    /**
     * @param Node $node
     * @return null
     */
    public function leaveNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            \array_pop($this->expressionOrderStack);
            $this->expressionDepth--;
        }
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt) {
            return null;
        }
        \array_pop($this->orderStack);
        $this->depth--;
        return null;
    }
}
