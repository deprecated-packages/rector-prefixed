<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract;
final class ClassLikeNameCollectingNodeVisitor extends \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node)
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if ($node->name === null) {
            return null;
        }
        $this->classLikeNames[] = $node->name->toString();
        return null;
    }
}
