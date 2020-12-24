<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ArrayPopFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_pop';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[0])) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $iterableAtLeastOnce = $argType->isIterableAtLeastOnce();
        if ($iterableAtLeastOnce->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        $constantArrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantArrays($argType);
        if (\count($constantArrays) > 0) {
            $valueTypes = [];
            foreach ($constantArrays as $constantArray) {
                $arrayKeyTypes = $constantArray->getKeyTypes();
                if (\count($arrayKeyTypes) === 0) {
                    $valueTypes[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
                    continue;
                }
                $valueTypes[] = $constantArray->getOffsetValueType($arrayKeyTypes[\count($arrayKeyTypes) - 1]);
            }
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$valueTypes);
        }
        $itemType = $argType->getIterableValueType();
        if ($iterableAtLeastOnce->yes()) {
            return $itemType;
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($itemType, new \_PhpScopere8e811afab72\PHPStan\Type\NullType());
    }
}
