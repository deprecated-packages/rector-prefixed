<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArrayReduceFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_reduce';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (!isset($functionCall->args[1])) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackType = $scope->getType($functionCall->args[1]->value);
        if ($callbackType->isCallable()->no()) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callbackType->getCallableParametersAcceptors($scope))->getReturnType();
        if (isset($functionCall->args[2])) {
            $initialType = $scope->getType($functionCall->args[2]->value);
        } else {
            $initialType = new \PHPStan\Type\NullType();
        }
        $arraysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \PHPStan\Type\TypeUtils::getConstantArrays($arraysType);
        if (\count($constantArrays) > 0) {
            $onlyEmpty = \true;
            $onlyNonEmpty = \true;
            foreach ($constantArrays as $constantArray) {
                $isEmpty = \count($constantArray->getValueTypes()) === 0;
                $onlyEmpty = $onlyEmpty && $isEmpty;
                $onlyNonEmpty = $onlyNonEmpty && !$isEmpty;
            }
            if ($onlyEmpty) {
                return $initialType;
            }
            if ($onlyNonEmpty) {
                return $callbackReturnType;
            }
        }
        return \PHPStan\Type\TypeCombinator::union($callbackReturnType, $initialType);
    }
}
