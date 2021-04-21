<?php

declare (strict_types=1);
namespace Rector\Comments;

use PhpParser\Comment;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use Rector\Comments\NodeTraverser\CommentRemovingNodeTraverser;
use Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @see \Rector\Comments\Tests\CommentRemover\CommentRemoverTest
 */
final class CommentRemover
{
    /**
     * @var CommentRemovingNodeTraverser
     */
    private $commentRemovingNodeTraverser;
    public function __construct(\Rector\Comments\NodeTraverser\CommentRemovingNodeTraverser $commentRemovingNodeTraverser)
    {
        $this->commentRemovingNodeTraverser = $commentRemovingNodeTraverser;
    }
    /**
     * @param Node[]|Node|null $node
     * @return mixed[]|null
     */
    public function removeFromNode($node)
    {
        if ($node === null) {
            return null;
        }
        $copiedNodes = $node;
        $nodes = \is_array($copiedNodes) ? $copiedNodes : [$copiedNodes];
        return $this->commentRemovingNodeTraverser->traverse($nodes);
    }
    /**
     * @return void
     */
    public function rollbackComments(\PhpParser\Node $node, \PhpParser\Comment $comment)
    {
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        $node->setDocComment(new \PhpParser\Comment\Doc($comment->getText()));
        $node->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, null);
    }
}
