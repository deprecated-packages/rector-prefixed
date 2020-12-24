<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class StrWordCountFunctionDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'str_word_count';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount === 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        } elseif ($argsCount === 2 || $argsCount === 3) {
            $formatType = $scope->getType($functionCall->args[1]->value);
            if ($formatType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $val = $formatType->getValue();
                if ($val === 0) {
                    // return word count
                    return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
                } elseif ($val === 1 || $val === 2) {
                    // return [word] or [offset => word]
                    return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
                }
                // return false, invalid format value specified
                return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            // Could be invalid format type as well, but parameter type checks will catch that.
            return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        // else fatal error; too many or too few arguments
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
}
