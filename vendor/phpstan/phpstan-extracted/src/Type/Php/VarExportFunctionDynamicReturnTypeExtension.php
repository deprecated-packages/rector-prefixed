<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\TypeCombinator;
class VarExportFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['var_export', 'highlight_file', 'highlight_string', 'print_r'], \true);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'var_export') {
            $fallbackReturnType = new \PHPStan\Type\NullType();
        } elseif ($functionReflection->getName() === 'print_r') {
            $fallbackReturnType = new \PHPStan\Type\Constant\ConstantBooleanType(\true);
        } else {
            $fallbackReturnType = new \PHPStan\Type\BooleanType();
        }
        if (\count($functionCall->args) < 1) {
            return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\StringType(), $fallbackReturnType);
        }
        if (\count($functionCall->args) < 2) {
            return $fallbackReturnType;
        }
        $returnArgumentType = $scope->getType($functionCall->args[1]->value);
        if ((new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($returnArgumentType)->yes()) {
            return new \PHPStan\Type\StringType();
        }
        return $fallbackReturnType;
    }
}
