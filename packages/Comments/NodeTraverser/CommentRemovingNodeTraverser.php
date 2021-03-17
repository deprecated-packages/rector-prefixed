<?php

declare (strict_types=1);
namespace Rector\Comments\NodeTraverser;

use PhpParser\NodeTraverser;
use Rector\Comments\NodeVisitor\CommentRemovingNodeVisitor;
final class CommentRemovingNodeTraverser extends \PhpParser\NodeTraverser
{
    /**
     * @param \Rector\Comments\NodeVisitor\CommentRemovingNodeVisitor $commentRemovingNodeVisitor
     */
    public function __construct($commentRemovingNodeVisitor)
    {
        $this->addVisitor($commentRemovingNodeVisitor);
    }
}
