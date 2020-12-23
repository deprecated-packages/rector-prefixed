<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Kernel;
final class KernelGetContainerAfterBootReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Symfony\Component\HttpKernel\Kernel::class;
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getContainer';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if (!$this->isCalledAfterBoot($scope, $methodCall)) {
            return $returnType;
        }
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            foreach ($returnType->getTypes() as $singleType) {
                if ($singleType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
                    return $singleType;
                }
            }
        }
        return $returnType;
    }
    private function isCalledAfterBoot(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $kernelBootMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($methodCall->var, 'boot');
        return !$scope->getType($kernelBootMethodCall) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
    }
}
