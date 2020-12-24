<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ArrayMapFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_map';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        $callableType = $scope->getType($functionCall->args[0]->value);
        if (!$callableType->isCallable()->no()) {
            $valueType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callableType->getCallableParametersAcceptors($scope))->getReturnType();
        }
        $arrayType = $scope->getType($functionCall->args[1]->value);
        $constantArrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantArrays($arrayType);
        if (\count($constantArrays) > 0) {
            $arrayTypes = [];
            foreach ($constantArrays as $constantArray) {
                $returnedArrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                foreach ($constantArray->getKeyTypes() as $keyType) {
                    $returnedArrayBuilder->setOffsetValueType($keyType, $valueType);
                }
                $arrayTypes[] = $returnedArrayBuilder->getArray();
            }
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
        } elseif ($arrayType->isArray()->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($arrayType->getIterableKeyType(), $valueType), ...\_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getAccessoryTypes($arrayType));
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $valueType);
    }
}
