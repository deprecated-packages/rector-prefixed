<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Comments;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Resolve nearest node, where we can add comment
 */
final class CommentableNodeResolver
{
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $currentNode = $node;
        $previousNode = $node;
        while (!$currentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt) {
            $currentNode = $currentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNode === null) {
                return $previousNode;
            }
            $previousNode = $currentNode;
        }
        return $currentNode;
    }
}
