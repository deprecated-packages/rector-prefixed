<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel;
final class KernelGetContainerAfterBootReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\Symfony\Component\HttpKernel\Kernel::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getContainer';
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if (!$this->isCalledAfterBoot($scope, $methodCall)) {
            return $returnType;
        }
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            foreach ($returnType->getTypes() as $singleType) {
                if ($singleType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
                    return $singleType;
                }
            }
        }
        return $returnType;
    }
    private function isCalledAfterBoot(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $kernelBootMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($methodCall->var, 'boot');
        return !$scope->getType($kernelBootMethodCall) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
    }
}
