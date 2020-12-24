<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class RandomIntFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'random_int';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $minType = $scope->getType($functionCall->args[0]->value)->toInteger();
        $maxType = $scope->getType($functionCall->args[1]->value)->toInteger();
        return $this->createRange($minType, $maxType);
    }
    private function createRange(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $minType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $maxType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $minValue = \array_reduce($minType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType ? $minType->getTypes() : [$minType], static function (int $carry, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : int {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType) {
                $value = $type->getMin();
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MIN;
            }
            return \min($value, $carry);
        }, \PHP_INT_MAX);
        $maxValue = \array_reduce($maxType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType ? $maxType->getTypes() : [$maxType], static function (int $carry, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : int {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType) {
                $value = $type->getMax();
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
                $value = $type->getValue();
            } else {
                $value = \PHP_INT_MAX;
            }
            return \max($value, $carry);
        }, \PHP_INT_MIN);
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerRangeType::fromInterval($minValue, $maxValue);
    }
}
