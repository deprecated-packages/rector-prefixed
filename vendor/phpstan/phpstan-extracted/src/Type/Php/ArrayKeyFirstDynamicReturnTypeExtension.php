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
class ArrayKeyFirstDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_key_first';
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
            $keyTypes = [];
            foreach ($constantArrays as $constantArray) {
                $arrayKeyTypes = $constantArray->getKeyTypes();
                if (\count($arrayKeyTypes) === 0) {
                    $keyTypes[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
                    continue;
                }
                $keyTypes[] = $arrayKeyTypes[0];
            }
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$keyTypes);
        }
        $keyType = $argType->getIterableKeyType();
        if ($iterableAtLeastOnce->yes()) {
            return $keyType;
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($keyType, new \_PhpScopere8e811afab72\PHPStan\Type\NullType());
    }
}
