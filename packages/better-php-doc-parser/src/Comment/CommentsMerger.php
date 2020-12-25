<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Comment;

use PhpParser\Comment;
use PhpParser\Node;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class CommentsMerger
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Node[] $mergedNodes
     */
    public function keepComments(\PhpParser\Node $newNode, array $mergedNodes) : void
    {
        $comments = $newNode->getComments();
        foreach ($mergedNodes as $mergedNode) {
            $comments = \array_merge($comments, $mergedNode->getComments());
        }
        if ($comments === []) {
            return;
        }
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
        // remove so comments "win"
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
    }
    public function keepParent(\PhpParser\Node $newNode, \PhpParser\Node $oldNode) : void
    {
        $parent = $oldNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return;
        }
        $arrayPhpDocInfo = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $arrayComments = $parent->getComments();
        if ($arrayPhpDocInfo === null && $arrayComments === []) {
            return;
        }
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $arrayPhpDocInfo);
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayComments);
    }
    public function keepChildren(\PhpParser\Node $newNode, \PhpParser\Node $oldNode) : void
    {
        $childrenComments = $this->collectChildrenComments($oldNode);
        if ($childrenComments === []) {
            return;
        }
        $commentContent = '';
        foreach ($childrenComments as $comment) {
            $commentContent .= $comment->getText() . \PHP_EOL;
        }
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \PhpParser\Comment($commentContent)]);
    }
    /**
     * @return Comment[]
     */
    private function collectChildrenComments(\PhpParser\Node $node) : array
    {
        $childrenComments = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use(&$childrenComments) : void {
            $comments = $node->getComments();
            if ($comments !== []) {
                $childrenComments = \array_merge($childrenComments, $comments);
            }
        });
        return $childrenComments;
    }
}
