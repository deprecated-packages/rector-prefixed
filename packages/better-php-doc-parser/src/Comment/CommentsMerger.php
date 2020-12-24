<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Comment;

use _PhpScoper0a6b37af0871\PhpParser\Comment;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class CommentsMerger
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Node[] $mergedNodes
     */
    public function keepComments(\_PhpScoper0a6b37af0871\PhpParser\Node $newNode, array $mergedNodes) : void
    {
        $comments = $newNode->getComments();
        foreach ($mergedNodes as $mergedNode) {
            $comments = \array_merge($comments, $mergedNode->getComments());
        }
        if ($comments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
        // remove so comments "win"
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
    }
    public function keepParent(\_PhpScoper0a6b37af0871\PhpParser\Node $newNode, \_PhpScoper0a6b37af0871\PhpParser\Node $oldNode) : void
    {
        $parent = $oldNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent === null) {
            return;
        }
        $arrayPhpDocInfo = $parent->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $arrayComments = $parent->getComments();
        if ($arrayPhpDocInfo === null && $arrayComments === []) {
            return;
        }
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $arrayPhpDocInfo);
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $arrayComments);
    }
    public function keepChildren(\_PhpScoper0a6b37af0871\PhpParser\Node $newNode, \_PhpScoper0a6b37af0871\PhpParser\Node $oldNode) : void
    {
        $childrenComments = $this->collectChildrenComments($oldNode);
        if ($childrenComments === []) {
            return;
        }
        $commentContent = '';
        foreach ($childrenComments as $comment) {
            $commentContent .= $comment->getText() . \PHP_EOL;
        }
        $newNode->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \_PhpScoper0a6b37af0871\PhpParser\Comment($commentContent)]);
    }
    /**
     * @return Comment[]
     */
    private function collectChildrenComments(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $childrenComments = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($node, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$childrenComments) : void {
            $comments = $node->getComments();
            if ($comments !== []) {
                $childrenComments = \array_merge($childrenComments, $comments);
            }
        });
        return $childrenComments;
    }
}
