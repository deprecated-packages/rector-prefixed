<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\PHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockBuilder;
class MockBuilderDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockBuilder::class;
    }
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return !\in_array($methodReflection->getName(), ['getMock', 'getMockForAbstractClass', 'getMockForTrait'], \true);
    }
    public function getTypeFromMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $scope->getType($methodCall->var);
    }
}
