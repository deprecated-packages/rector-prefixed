<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract;
final class ClassLikeNameCollectingNodeVisitor extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitorAbstract
{
    /**
     * @var string[]
     */
    private $classLikeNames = [];
    /**
     * @return string[]
     */
    public function getClassLikeNames() : array
    {
        return $this->classLikeNames;
    }
    public function enterNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node)
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if ($node->name === null) {
            return null;
        }
        $this->classLikeNames[] = $node->name->toString();
        return null;
    }
}
