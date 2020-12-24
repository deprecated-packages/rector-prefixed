<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Comment;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Comment;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
final class CommentsMerger
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Node[] $mergedNodes
     */
    public function keepComments(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $newNode, array $mergedNodes) : void
    {
        $comments = $newNode->getComments();
        foreach ($mergedNodes as $mergedNode) {
            $comments = \array_merge($comments, $mergedNode->getComments());
        }
        if ($comments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
        // remove so comments "win"
        $newNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
    }
    public function keepParent(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $newNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $oldNode) : void
    {
        $parent = $oldNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return;
        }
        $arrayPhpDocInfo = $parent->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $arrayComments = $parent->getComments();
        if ($arrayPhpDocInfo === null && $arrayComments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $arrayPhpDocInfo);
        $newNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayComments);
    }
    public function keepChildren(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $newNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $oldNode) : void
    {
        $childrenComments = $this->collectChildrenComments($oldNode);
        if ($childrenComments === []) {
            return;
        }
        $commentContent = '';
        foreach ($childrenComments as $comment) {
            $commentContent .= $comment->getText() . \PHP_EOL;
        }
        $newNode->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Comment($commentContent)]);
    }
    /**
     * @return Comment[]
     */
    private function collectChildrenComments(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        $childrenComments = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use(&$childrenComments) : void {
            $comments = $node->getComments();
            if ($comments !== []) {
                $childrenComments = \array_merge($childrenComments, $comments);
            }
        });
        return $childrenComments;
    }
}
