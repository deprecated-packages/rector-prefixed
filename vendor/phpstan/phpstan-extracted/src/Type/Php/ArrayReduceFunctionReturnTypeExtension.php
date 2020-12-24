<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class ArrayReduceFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_reduce';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[1])) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackType = $scope->getType($functionCall->args[1]->value);
        if ($callbackType->isCallable()->no()) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackReturnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callbackType->getCallableParametersAcceptors($scope))->getReturnType();
        if (isset($functionCall->args[2])) {
            $initialType = $scope->getType($functionCall->args[2]->value);
        } else {
            $initialType = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        }
        $arraysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($arraysType);
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
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($callbackReturnType, $initialType);
    }
}
