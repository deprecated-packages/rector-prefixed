<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionMethod;
/**
 * Decorate setUp() and tearDown() with "void" when local TestClass class uses them
 */
final class PHPUnitTypeDeclarationDecorator
{
    public function decorate(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!\class_exists('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase')) {
            return;
        }
        // skip test run
        if (\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $reflectionMethod = new \ReflectionMethod('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::SET_UP);
        if (!$reflectionMethod->hasReturnType()) {
            return;
        }
        $returnType = (string) $reflectionMethod->getReturnType();
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($returnType);
    }
}
