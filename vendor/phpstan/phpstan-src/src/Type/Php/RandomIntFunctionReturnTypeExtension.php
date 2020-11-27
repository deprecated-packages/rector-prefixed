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
use PHPStan\Type\UnionType;
class RandomIntFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'random_int';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $minType = $scope->getType($functionCall->args[0]->value)->toInteger();
        $maxType = $scope->getType($functionCall->args[1]->value)->toInteger();
        return $this->createRange($minType, $maxType);
    }
    private function createRange(\PHPStan\Type\Type $minType, \PHPStan\Type\Type $maxType) : \PHPStan\Type\Type
    {
        $minValue = \array_reduce($minType instanceof \PHPStan\Type\UnionType ? $minType->getTypes() : [$minType], static function (int $carry, \PHPStan\Type\Type $type) : int {
            if ($type instanceof \PHPStan\Type\IntegerRangeType) {
                $value = $type->getMin();
            } elseif ($type instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MIN;
            }
            return \min($value, $carry);
        }, \PHP_INT_MAX);
        $maxValue = \array_reduce($maxType instanceof \PHPStan\Type\UnionType ? $maxType->getTypes() : [$maxType], static function (int $carry, \PHPStan\Type\Type $type) : int {
            if ($type instanceof \PHPStan\Type\IntegerRangeType) {
                $value = $type->getMax();
            } elseif ($type instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MAX;
            }
            return \max($value, $carry);
        }, \PHP_INT_MIN);
        return \PHPStan\Type\IntegerRangeType::fromInterval($minValue, $maxValue);
    }
}
