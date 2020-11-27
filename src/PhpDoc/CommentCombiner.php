<?php

declare (strict_types=1);
namespace Rector\Core\PhpDoc;

use PhpParser\Comment;
use PhpParser\Node;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class CommentCombiner
{
    /**
     * @var Comment[]
     */
    private $comments = [];
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function combineCommentsToNode(\PhpParser\Node $originalNode, \PhpParser\Node $newNode) : void
    {
        $this->comments = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($originalNode, function (\PhpParser\Node $node) : void {
            if ($node->hasAttribute('comments')) {
                $this->comments = \array_merge($this->comments, $node->getComments());
            }
        });
        if ($this->comments === []) {
            return;
        }
        $commentContent = '';
        foreach ($this->comments as $comment) {
            $commentContent .= $comment->getText() . \PHP_EOL;
        }
        $newNode->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, [new \PhpParser\Comment($commentContent)]);
    }
}
