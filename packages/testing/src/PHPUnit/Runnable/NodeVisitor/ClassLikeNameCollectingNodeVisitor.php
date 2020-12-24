<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\NodeVisitor;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract;
final class ClassLikeNameCollectingNodeVisitor extends \_PhpScoperb75b35f52b74\PhpParser\NodeVisitorAbstract
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
    public function enterNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node)
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
            return null;
        }
        if ($node->name === null) {
            return null;
        }
        $this->classLikeNames[] = $node->name->toString();
        return null;
    }
}
