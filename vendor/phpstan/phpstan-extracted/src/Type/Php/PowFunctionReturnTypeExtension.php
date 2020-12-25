<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class PowFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pow';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $defaultReturnType = new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntegerType()]);
        if (\count($functionCall->args) < 2) {
            return $defaultReturnType;
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($firstArgType instanceof \PHPStan\Type\MixedType || $secondArgType instanceof \PHPStan\Type\MixedType) {
            return $defaultReturnType;
        }
        $object = new \PHPStan\Type\ObjectWithoutClassType();
        if (!$object->isSuperTypeOf($firstArgType)->no() || !$object->isSuperTypeOf($secondArgType)->no()) {
            return \PHPStan\Type\TypeCombinator::union($firstArgType, $secondArgType);
        }
        return $defaultReturnType;
    }
}
