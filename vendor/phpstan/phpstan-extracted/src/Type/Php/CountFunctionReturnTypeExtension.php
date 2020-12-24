<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class CountFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'count';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 1) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        if (\count($functionCall->args) > 1) {
            $mode = $scope->getType($functionCall->args[1]->value);
            if ($mode->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(\COUNT_RECURSIVE))->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
            }
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($scope->getType($functionCall->args[0]->value));
        if (\count($constantArrays) === 0) {
            if ($argType->isIterableAtLeastOnce()->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerRangeType::fromInterval(1, null);
            }
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $countTypes = [];
        foreach ($constantArrays as $array) {
            $countTypes[] = $array->count();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$countTypes);
    }
}
