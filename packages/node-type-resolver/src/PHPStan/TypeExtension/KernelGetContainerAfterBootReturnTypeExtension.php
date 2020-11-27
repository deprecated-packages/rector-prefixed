<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan\TypeExtension;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ErrorType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use _PhpScopera143bcca66cb\Symfony\Component\HttpKernel\Kernel;
final class KernelGetContainerAfterBootReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScopera143bcca66cb\Symfony\Component\HttpKernel\Kernel::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getContainer';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if (!$this->isCalledAfterBoot($scope, $methodCall)) {
            return $returnType;
        }
        if ($returnType instanceof \PHPStan\Type\UnionType) {
            foreach ($returnType->getTypes() as $singleType) {
                if ($singleType instanceof \PHPStan\Type\ObjectType) {
                    return $singleType;
                }
            }
        }
        return $returnType;
    }
    private function isCalledAfterBoot(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $kernelBootMethodCall = new \PhpParser\Node\Expr\MethodCall($methodCall->var, 'boot');
        return !$scope->getType($kernelBootMethodCall) instanceof \PHPStan\Type\ErrorType;
    }
}
