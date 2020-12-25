<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit;

use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\ValueObject\MethodName;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionMethod;
/**
 * Decorate setUp() and tearDown() with "void" when local TestClass class uses them
 */
final class PHPUnitTypeDeclarationDecorator
{
    public function decorate(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!\class_exists('_PhpScoper267b3276efc2\\PHPUnit\\Framework\\TestCase')) {
            return;
        }
        // skip test run
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $reflectionMethod = new \ReflectionMethod('_PhpScoper267b3276efc2\\PHPUnit\\Framework\\TestCase', \Rector\Core\ValueObject\MethodName::SET_UP);
        if (!$reflectionMethod->hasReturnType()) {
            return;
        }
        $returnType = (string) $reflectionMethod->getReturnType();
        $classMethod->returnType = new \PhpParser\Node\Identifier($returnType);
    }
}
