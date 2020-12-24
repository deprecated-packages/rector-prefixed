<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionMethod;
/**
 * Decorate setUp() and tearDown() with "void" when local TestClass class uses them
 */
final class PHPUnitTypeDeclarationDecorator
{
    public function decorate(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!\class_exists('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase')) {
            return;
        }
        // skip test run
        if (\_PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $reflectionMethod = new \ReflectionMethod('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP);
        if (!$reflectionMethod->hasReturnType()) {
            return;
        }
        $returnType = (string) $reflectionMethod->getReturnType();
        $classMethod->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($returnType);
    }
}
