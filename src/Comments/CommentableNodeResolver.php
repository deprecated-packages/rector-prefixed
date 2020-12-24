<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Comments;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Resolve nearest node, where we can add comment
 */
final class CommentableNodeResolver
{
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $currentNode = $node;
        $previousNode = $node;
        while (!$currentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt) {
            $currentNode = $currentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNode === null) {
                return $previousNode;
            }
            $previousNode = $currentNode;
        }
        return $currentNode;
    }
}
