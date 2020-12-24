<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Comments;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * Resolve nearest node, where we can add comment
 */
final class CommentableNodeResolver
{
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $currentNode = $node;
        $previousNode = $node;
        while (!$currentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt) {
            $currentNode = $currentNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($currentNode === null) {
                return $previousNode;
            }
            $previousNode = $currentNode;
        }
        return $currentNode;
    }
}
