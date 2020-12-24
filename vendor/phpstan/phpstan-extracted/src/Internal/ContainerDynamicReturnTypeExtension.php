<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Internal;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class ContainerDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return \in_array($methodReflection->getName(), ['getByType'], \true);
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 0) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($methodCall->args[0]->value);
        if (!$argType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $type = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($argType->getValue());
        if ($methodReflection->getName() === 'getByType' && \count($methodCall->args) >= 2) {
            $argType = $scope->getType($methodCall->args[1]->value);
            if ($argType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType && $argType->getValue()) {
                $type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::addNull($type);
            }
        }
        return $type;
    }
}
