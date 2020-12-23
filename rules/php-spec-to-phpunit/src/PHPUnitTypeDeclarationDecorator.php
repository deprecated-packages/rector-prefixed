<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PhpSpecToPHPUnit;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionMethod;
/**
 * Decorate setUp() and tearDown() with "void" when local TestClass class uses them
 */
final class PHPUnitTypeDeclarationDecorator
{
    public function decorate(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if (!\class_exists('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase')) {
            return;
        }
        // skip test run
        if (\_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        $reflectionMethod = new \ReflectionMethod('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::SET_UP);
        if (!$reflectionMethod->hasReturnType()) {
            return;
        }
        $returnType = (string) $reflectionMethod->getReturnType();
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($returnType);
    }
}
