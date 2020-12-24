<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PSR4\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
final class NamespaceManipulator
{
    public function removeClassLikes(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_ $namespace) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_
    {
        foreach ($namespace->stmts as $key => $namespaceStatement) {
            if (!$namespaceStatement instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike) {
                continue;
            }
            unset($namespace->stmts[$key]);
        }
        return $namespace;
    }
}
