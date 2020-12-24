<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Internal;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class UnionTypeGetInternalDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType::class;
    }
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getInternal';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (\count($methodCall->args) < 2) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $getterClosureType = $scope->getType($methodCall->args[1]->value);
        return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($getterClosureType->getCallableParametersAcceptors($scope))->getReturnType();
    }
}
