<?php

declare (strict_types=1);
namespace Rector\PSR4\NodeManipulator;

use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
final class NamespaceManipulator
{
    /**
     * @return void
     */
    public function removeClassLikes(\PhpParser\Node\Stmt\Namespace_ $namespace)
    {
        foreach ($namespace->stmts as $key => $namespaceStatement) {
            if (!$namespaceStatement instanceof \PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            unset($namespace->stmts[$key]);
        }
    }
}
