<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder;
final class StaticMethodClassFactory
{
    /**
     * @var ClassMethodFactory
     */
    private $classMethodFactory;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Legacy\NodeFactory\ClassMethodFactory $classMethodFactory, \_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classMethodFactory = $classMethodFactory;
        $this->classNaming = $classNaming;
    }
    /**
     * @param Function_[] $functions
     */
    public function createStaticMethodClass(string $shortClassName, array $functions) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $classBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        foreach ($functions as $function) {
            $staticClassMethod = $this->createStaticMethod($function);
            $classBuilder->addStmt($staticClassMethod);
        }
        return $classBuilder->getNode();
    }
    private function createStaticMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_ $function) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->classNaming->createMethodNameFromFunction($function);
        return $this->classMethodFactory->createClassMethodFromFunction($methodName, $function);
    }
}
