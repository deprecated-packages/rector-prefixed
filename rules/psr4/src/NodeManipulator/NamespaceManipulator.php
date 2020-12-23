<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PSR4\NodeManipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
final class NamespaceManipulator
{
    public function removeClassLikes(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_ $namespace) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_
    {
        foreach ($namespace->stmts as $key => $namespaceStatement) {
            if (!$namespaceStatement instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            unset($namespace->stmts[$key]);
        }
        return $namespace;
    }
}
