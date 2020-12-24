<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class MicrotimeFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'microtime';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
        }
        if ($compareTypes === $isFalseType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        }
        if ($argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType()]);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType()]);
    }
}
