<?php

declare (strict_types=1);
namespace Rector\Core\Comments;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Resolve nearest node, where we can add comment
 */
final class CommentableNodeResolver
{
    public function resolve(\PhpParser\Node $node) : \PhpParser\Node
    {
        $currentNode = $node;
        $previousNode = $node;
        while (!$currentNode instanceof \PhpParser\Node\Stmt) {
            $currentNode = $currentNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$currentNode instanceof \PhpParser\Node) {
                return $previousNode;
            }
            $previousNode = $currentNode;
        }
        return $currentNode;
    }
}
