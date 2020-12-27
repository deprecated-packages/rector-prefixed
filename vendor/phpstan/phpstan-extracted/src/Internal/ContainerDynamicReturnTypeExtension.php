<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class ContainerDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \RectorPrefix20201227\PHPStan\DependencyInjection\Container::class;
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return \in_array($methodReflection->getName(), ['getByType'], \true);
    }
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 0) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($methodCall->args[0]->value);
        if (!$argType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
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
