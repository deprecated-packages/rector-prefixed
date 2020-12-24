<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Legacy\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Legacy\NodeFactory\ClassMethodFactory $classMethodFactory, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classMethodFactory = $classMethodFactory;
        $this->classNaming = $classNaming;
    }
    /**
     * @param Function_[] $functions
     */
    public function createStaticMethodClass(string $shortClassName, array $functions) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_
    {
        $classBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        foreach ($functions as $function) {
            $staticClassMethod = $this->createStaticMethod($function);
            $classBuilder->addStmt($staticClassMethod);
        }
        return $classBuilder->getNode();
    }
    private function createStaticMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->classNaming->createMethodNameFromFunction($function);
        return $this->classMethodFactory->createClassMethodFromFunction($methodName, $function);
    }
}
