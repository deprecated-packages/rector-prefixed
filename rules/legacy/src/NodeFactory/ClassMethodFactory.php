<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
final class ClassMethodFactory
{
    public function createClassMethodFromFunction(string $methodName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_ $function) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder($methodName);
        $methodBuilder->makePublic();
        $methodBuilder->makeStatic();
        $methodBuilder->addStmts($function->stmts);
        return $methodBuilder->getNode();
    }
}
