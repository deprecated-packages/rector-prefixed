<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ArrayFillKeysFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill_keys';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = $scope->getType($functionCall->args[1]->value);
        $keysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantArrays($keysType);
        if (\count($constantArrays) === 0) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($keysType->getIterableValueType(), $valueType);
        }
        $arrayTypes = [];
        foreach ($constantArrays as $constantArray) {
            $arrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($constantArray->getValueTypes() as $keyType) {
                $arrayBuilder->setOffsetValueType($keyType, $valueType);
            }
            $arrayTypes[] = $arrayBuilder->getArray();
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
