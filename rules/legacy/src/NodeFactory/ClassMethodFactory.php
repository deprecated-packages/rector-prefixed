<?php

declare (strict_types=1);
namespace Rector\Legacy\NodeFactory;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use Rector\Core\PhpParser\Builder\MethodBuilder;
final class ClassMethodFactory
{
    public function createClassMethodFromFunction(string $methodName, \PhpParser\Node\Stmt\Function_ $function) : \PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \Rector\Core\PhpParser\Builder\MethodBuilder($methodName);
        $methodBuilder->makePublic();
        $methodBuilder->makeStatic();
        $methodBuilder->addStmts($function->stmts);
        return $methodBuilder->getNode();
    }
}
