<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Comment;

use PhpParser\Node;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class MergedNodeCommentPreserver
{
    /**
     * @param Node[] $mergedNodes
     */
    public function keepComments(\PhpParser\Node $newNode, array $mergedNodes) : void
    {
        $comments = [];
        foreach ($mergedNodes as $mergedNode) {
            $comments = \array_merge($comments, $mergedNode->getComments());
        }
        if ($comments === []) {
            return;
        }
        $comments = \array_merge($newNode->getComments(), $comments);
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, $comments);
    }
}
