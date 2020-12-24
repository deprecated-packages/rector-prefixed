<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Legacy\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ClassBuilder;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Legacy\NodeFactory\ClassMethodFactory $classMethodFactory, \_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classMethodFactory = $classMethodFactory;
        $this->classNaming = $classNaming;
    }
    /**
     * @param Function_[] $functions
     */
    public function createStaticMethodClass(string $shortClassName, array $functions) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_
    {
        $classBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ClassBuilder($shortClassName);
        $classBuilder->makeFinal();
        foreach ($functions as $function) {
            $staticClassMethod = $this->createStaticMethod($function);
            $classBuilder->addStmt($staticClassMethod);
        }
        return $classBuilder->getNode();
    }
    private function createStaticMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_ $function) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->classNaming->createMethodNameFromFunction($function);
        return $this->classMethodFactory->createClassMethodFromFunction($methodName, $function);
    }
}
