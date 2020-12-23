<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeVisitor;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class StatementNodeVisitor extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract
{
    /**
     * @var Stmt|null
     */
    private $previousStmt;
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->previousStmt = null;
        return null;
    }
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt) {
                return null;
            }
            $node->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT, $this->previousStmt);
            $node->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT, $node);
            $this->previousStmt = $node;
        }
        if (\property_exists($node, 'stmts')) {
            $previous = $node;
            foreach ((array) $node->stmts as $stmt) {
                $stmt->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT, $previous);
                $stmt->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT, $stmt);
                $previous = $stmt;
            }
        }
        $currentStmt = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if ($parent && !$currentStmt) {
            $node->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT, $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_STATEMENT));
            $node->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT, $parent->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT));
        }
        return null;
    }
}
