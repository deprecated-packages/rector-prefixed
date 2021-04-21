<?php

declare(strict_types=1);

namespace Rector\BetterPhpDocParser\Comment;

use PhpParser\Comment;
use PhpParser\Node;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;

final class CommentsMerger
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;

    public function __construct(SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }

    /**
     * @param Node[] $mergedNodes
     * @return void
     */
    public function keepComments(Node $newNode, array $mergedNodes)
    {
        $comments = $newNode->getComments();

        foreach ($mergedNodes as $mergedNode) {
            $comments = array_merge($comments, $mergedNode->getComments());
        }

        if ($comments === []) {
            return;
        }

        $newNode->setAttribute(AttributeKey::COMMENTS, $comments);

        // remove so comments "win"
        $newNode->setAttribute(AttributeKey::PHP_DOC_INFO, null);
    }

    /**
     * @return void
     */
    public function keepParent(Node $newNode, Node $oldNode)
    {
        $parent = $oldNode->getAttribute(AttributeKey::PARENT_NODE);
        if (! $parent instanceof Node) {
            return;
        }

        $phpDocInfo = $parent->getAttribute(AttributeKey::PHP_DOC_INFO);
        $comments = $parent->getComments();

        if ($phpDocInfo === null && $comments === []) {
            return;
        }

        $newNode->setAttribute(AttributeKey::PHP_DOC_INFO, $phpDocInfo);
        $newNode->setAttribute(AttributeKey::COMMENTS, $comments);
    }

    /**
     * @return void
     */
    public function keepChildren(Node $newNode, Node $oldNode)
    {
        $childrenComments = $this->collectChildrenComments($oldNode);

        if ($childrenComments === []) {
            return;
        }

        $commentContent = '';
        foreach ($childrenComments as $childComment) {
            $commentContent .= $childComment->getText() . PHP_EOL;
        }

        $newNode->setAttribute(AttributeKey::COMMENTS, [new Comment($commentContent)]);
    }

    /**
     * @return Comment[]
     */
    private function collectChildrenComments(Node $node): array
    {
        $childrenComments = [];

        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($node, function (Node $node) use (
            &$childrenComments
        ) {
            $comments = $node->getComments();

            if ($comments !== []) {
                $childrenComments = array_merge($childrenComments, $comments);
            }
        });

        return $childrenComments;
    }
}
