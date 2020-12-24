<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Comment;

use _PhpScoperb75b35f52b74\PhpParser\Comment;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class CommentsMerger
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Node[] $mergedNodes
     */
    public function keepComments(\_PhpScoperb75b35f52b74\PhpParser\Node $newNode, array $mergedNodes) : void
    {
        $comments = $newNode->getComments();
        foreach ($mergedNodes as $mergedNode) {
            $comments = \array_merge($comments, $mergedNode->getComments());
        }
        if ($comments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
        // remove so comments "win"
        $newNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
    }
    public function keepParent(\_PhpScoperb75b35f52b74\PhpParser\Node $newNode, \_PhpScoperb75b35f52b74\PhpParser\Node $oldNode) : void
    {
        $parent = $oldNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return;
        }
        $arrayPhpDocInfo = $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $arrayComments = $parent->getComments();
        if ($arrayPhpDocInfo === null && $arrayComments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $arrayPhpDocInfo);
        $newNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayComments);
    }
    public function keepChildren(\_PhpScoperb75b35f52b74\PhpParser\Node $newNode, \_PhpScoperb75b35f52b74\PhpParser\Node $oldNode) : void
    {
        $childrenComments = $this->collectChildrenComments($oldNode);
        if ($childrenComments === []) {
            return;
        }
        $commentContent = '';
        foreach ($childrenComments as $comment) {
            $commentContent .= $comment->getText() . \PHP_EOL;
        }
        $newNode->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \_PhpScoperb75b35f52b74\PhpParser\Comment($commentContent)]);
    }
    /**
     * @return Comment[]
     */
    private function collectChildrenComments(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : array
    {
        $childrenComments = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$childrenComments) : void {
            $comments = $node->getComments();
            if ($comments !== []) {
                $childrenComments = \array_merge($childrenComments, $comments);
            }
        });
        return $childrenComments;
    }
}
