<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Legacy\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
final class ClassMethodFactory
{
    public function createClassMethodFromFunction(string $methodName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder($methodName);
        $methodBuilder->makePublic();
        $methodBuilder->makeStatic();
        $methodBuilder->addStmts($function->stmts);
        return $methodBuilder->getNode();
    }
}
