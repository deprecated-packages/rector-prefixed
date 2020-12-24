<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Legacy\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
final class ClassMethodFactory
{
    public function createClassMethodFromFunction(string $methodName, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder($methodName);
        $methodBuilder->makePublic();
        $methodBuilder->makeStatic();
        $methodBuilder->addStmts($function->stmts);
        return $methodBuilder->getNode();
    }
}
