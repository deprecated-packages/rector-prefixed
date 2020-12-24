<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class RandomIntFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'random_int';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $minType = $scope->getType($functionCall->args[0]->value)->toInteger();
        $maxType = $scope->getType($functionCall->args[1]->value)->toInteger();
        return $this->createRange($minType, $maxType);
    }
    private function createRange(\_PhpScopere8e811afab72\PHPStan\Type\Type $minType, \_PhpScopere8e811afab72\PHPStan\Type\Type $maxType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $minValue = \array_reduce($minType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType ? $minType->getTypes() : [$minType], static function (int $carry, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : int {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType) {
                $value = $type->getMin();
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MIN;
            }
            return \min($value, $carry);
        }, \PHP_INT_MAX);
        $maxValue = \array_reduce($maxType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType ? $maxType->getTypes() : [$maxType], static function (int $carry, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : int {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType) {
                $value = $type->getMax();
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MAX;
            }
            return \max($value, $carry);
        }, \PHP_INT_MIN);
        return \_PhpScopere8e811afab72\PHPStan\Type\IntegerRangeType::fromInterval($minValue, $maxValue);
    }
}
