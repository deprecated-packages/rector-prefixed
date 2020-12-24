<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ReplaceFunctionsDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $functions = ['preg_replace' => 2, 'preg_replace_callback' => 2, 'preg_replace_callback_array' => 1, 'str_replace' => 2, 'str_ireplace' => 2, 'substr_replace' => 0];
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \array_key_exists($functionReflection->getName(), $this->functions);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $this->getPreliminarilyResolvedTypeFromFunctionCall($functionReflection, $functionCall, $scope);
        $possibleTypes = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::containsNull($possibleTypes)) {
            $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::addNull($type);
        }
        return $type;
    }
    private function getPreliminarilyResolvedTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $argumentPosition = $this->functions[$functionReflection->getName()];
        if (\count($functionCall->args) <= $argumentPosition) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $subjectArgumentType = $scope->getType($functionCall->args[$argumentPosition]->value);
        $defaultReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($subjectArgumentType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $stringType = new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        $isStringSuperType = $stringType->isSuperTypeOf($subjectArgumentType);
        $isArraySuperType = $arrayType->isSuperTypeOf($subjectArgumentType);
        $compareSuperTypes = $isStringSuperType->compareTo($isArraySuperType);
        if ($compareSuperTypes === $isStringSuperType) {
            return $stringType;
        } elseif ($compareSuperTypes === $isArraySuperType) {
            if ($subjectArgumentType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return $subjectArgumentType->generalizeValues();
            }
            return $subjectArgumentType;
        }
        return $defaultReturnType;
    }
}
