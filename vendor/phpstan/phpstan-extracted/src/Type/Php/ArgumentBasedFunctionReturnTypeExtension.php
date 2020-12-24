<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ArgumentBasedFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var int[] */
    private $functionNames = ['array_unique' => 0, 'array_reverse' => 0, 'array_change_key_case' => 0, 'array_diff_assoc' => 0, 'array_diff_key' => 0, 'array_diff_uassoc' => 0, 'array_diff_ukey' => 0, 'array_diff' => 0, 'array_udiff_assoc' => 0, 'array_udiff_uassoc' => 0, 'array_udiff' => 0, 'array_intersect_assoc' => 0, 'array_intersect_key' => 0, 'array_intersect_uassoc' => 0, 'array_intersect_ukey' => 0, 'array_intersect' => 0, 'array_uintersect_assoc' => 0, 'array_uintersect_uassoc' => 0, 'array_uintersect' => 0, 'iterator_to_array' => 0];
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return isset($this->functionNames[$functionReflection->getName()]);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $argumentPosition = $this->functionNames[$functionReflection->getName()];
        if (!isset($functionCall->args[$argumentPosition])) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $argument = $functionCall->args[$argumentPosition];
        $argumentType = $scope->getType($argument->value);
        $argumentKeyType = $argumentType->getIterableKeyType();
        $argumentValueType = $argumentType->getIterableValueType();
        if ($argument->unpack) {
            $argumentKeyType = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($argumentKeyType);
            $argumentValueType = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($argumentValueType->getIterableValueType());
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($argumentKeyType, $argumentValueType);
    }
}
