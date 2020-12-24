<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class StrtotimeFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'strtotime';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            return $defaultReturnType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $result = \array_unique(\array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType $string) : bool {
            return \is_int(\strtotime($string->getValue()));
        }, \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($argType)));
        if (\count($result) !== 1) {
            return $defaultReturnType;
        }
        return $result[0] ? new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType() : new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
