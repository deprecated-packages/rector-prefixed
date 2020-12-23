<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Comments;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Resolve nearest node, where we can add comment
 */
final class CommentableNodeResolver
{
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $currentNode = $node;
        $previousNode = $node;
        while (!$currentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt) {
            $currentNode = $currentNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNode === null) {
                return $previousNode;
            }
            $previousNode = $currentNode;
        }
        return $currentNode;
    }
}
