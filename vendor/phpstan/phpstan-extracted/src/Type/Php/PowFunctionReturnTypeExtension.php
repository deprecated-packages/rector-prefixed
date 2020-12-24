<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class PowFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pow';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $defaultReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType([new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        if (\count($functionCall->args) < 2) {
            return $defaultReturnType;
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($firstArgType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType || $secondArgType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $defaultReturnType;
        }
        $object = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
        if (!$object->isSuperTypeOf($firstArgType)->no() || !$object->isSuperTypeOf($secondArgType)->no()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($firstArgType, $secondArgType);
        }
        return $defaultReturnType;
    }
}
