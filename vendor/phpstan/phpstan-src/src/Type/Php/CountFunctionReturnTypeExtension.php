<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\IntegerRangeType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class CountFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'count';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 1) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        if (\count($functionCall->args) > 1) {
            $mode = $scope->getType($functionCall->args[1]->value);
            if ($mode->isSuperTypeOf(new \PHPStan\Type\Constant\ConstantIntegerType(\COUNT_RECURSIVE))->yes()) {
                return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
            }
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \PHPStan\Type\TypeUtils::getConstantArrays($scope->getType($functionCall->args[0]->value));
        if (\count($constantArrays) === 0) {
            if ($argType->isIterableAtLeastOnce()->yes()) {
                return \PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            }
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $countTypes = [];
        foreach ($constantArrays as $array) {
            $countTypes[] = $array->count();
        }
        return \PHPStan\Type\TypeCombinator::union(...$countTypes);
    }
}
