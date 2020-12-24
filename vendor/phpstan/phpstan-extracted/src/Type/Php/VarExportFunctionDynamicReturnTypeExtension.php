<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class VarExportFunctionDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['var_export', 'highlight_file', 'highlight_string', 'print_r'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'var_export') {
            $fallbackReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        } elseif ($functionReflection->getName() === 'print_r') {
            $fallbackReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true);
        } else {
            $fallbackReturnType = new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        }
        if (\count($functionCall->args) < 1) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), $fallbackReturnType);
        }
        if (\count($functionCall->args) < 2) {
            return $fallbackReturnType;
        }
        $returnArgumentType = $scope->getType($functionCall->args[1]->value);
        if ((new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($returnArgumentType)->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        }
        return $fallbackReturnType;
    }
}
