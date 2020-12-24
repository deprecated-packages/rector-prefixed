<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Kernel;
final class KernelGetContainerAfterBootReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a6b37af0871\Symfony\Component\HttpKernel\Kernel::class;
    }
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getContainer';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $returnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if (!$this->isCalledAfterBoot($scope, $methodCall)) {
            return $returnType;
        }
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            foreach ($returnType->getTypes() as $singleType) {
                if ($singleType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
                    return $singleType;
                }
            }
        }
        return $returnType;
    }
    private function isCalledAfterBoot(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $kernelBootMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($methodCall->var, 'boot');
        return !$scope->getType($kernelBootMethodCall) instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
    }
}
