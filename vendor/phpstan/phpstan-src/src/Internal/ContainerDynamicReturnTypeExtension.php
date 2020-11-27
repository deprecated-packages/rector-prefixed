<?php

declare (strict_types=1);
namespace PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\Container;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class ContainerDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \PHPStan\DependencyInjection\Container::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return \in_array($methodReflection->getName(), ['getByType'], \true);
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 0) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($methodCall->args[0]->value);
        if (!$argType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $type = new \PHPStan\Type\ObjectType($argType->getValue());
        if ($methodReflection->getName() === 'getByType' && \count($methodCall->args) >= 2) {
            $argType = $scope->getType($methodCall->args[1]->value);
            if ($argType instanceof \PHPStan\Type\Constant\ConstantBooleanType && $argType->getValue()) {
                $type = \PHPStan\Type\TypeCombinator::addNull($type);
            }
        }
        return $type;
    }
}
