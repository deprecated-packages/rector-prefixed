<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PSR4\NodeManipulator;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
final class NamespaceManipulator
{
    public function removeClassLikes(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        foreach ($namespace->stmts as $key => $namespaceStatement) {
            if (!$namespaceStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            unset($namespace->stmts[$key]);
        }
        return $namespace;
    }
}
