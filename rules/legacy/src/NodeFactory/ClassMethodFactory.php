<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Legacy\NodeFactory;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder;
final class ClassMethodFactory
{
    public function createClassMethodFromFunction(string $methodName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Builder\MethodBuilder($methodName);
        $methodBuilder->makePublic();
        $methodBuilder->makeStatic();
        $methodBuilder->addStmts($function->stmts);
        return $methodBuilder->getNode();
    }
}
