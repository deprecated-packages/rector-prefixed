<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
final class ClassLikeNameCollectingNodeVisitor extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if ($node->name === null) {
            return null;
        }
        $this->classLikeNames[] = $node->name->toString();
        return null;
    }
}
