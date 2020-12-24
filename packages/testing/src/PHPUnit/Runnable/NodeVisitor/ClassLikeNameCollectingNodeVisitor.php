<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract;
final class ClassLikeNameCollectingNodeVisitor extends \_PhpScoper0a6b37af0871\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node)
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if ($node->name === null) {
            return null;
        }
        $this->classLikeNames[] = $node->name->toString();
        return null;
    }
}
