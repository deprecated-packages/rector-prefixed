<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Legacy\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Legacy\NodeFactory\ClassMethodFactory $classMethodFactory, \_PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classMethodFactory = $classMethodFactory;
        $this->classNaming = $classNaming;
    }
    /**
     * @param Function_[] $functions
     */
    public function createStaticMethodClass(string $shortClassName, array $functions) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        $classBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        foreach ($functions as $function) {
            $staticClassMethod = $this->createStaticMethod($function);
            $classBuilder->addStmt($staticClassMethod);
        }
        return $classBuilder->getNode();
    }
    private function createStaticMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->classNaming->createMethodNameFromFunction($function);
        return $this->classMethodFactory->createClassMethodFromFunction($methodName, $function);
    }
}
