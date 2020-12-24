<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class JsonThrowOnErrorDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $argumentPositions = ['json_encode' => 1, 'json_decode' => 3];
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $this->reflectionProvider->hasConstant(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null) && \in_array($functionReflection->getName(), ['json_encode', 'json_decode'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $argumentPosition = $this->argumentPositions[$functionReflection->getName()];
        $defaultReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (!isset($functionCall->args[$argumentPosition])) {
            return $defaultReturnType;
        }
        $optionsExpr = $functionCall->args[$argumentPosition]->value;
        $constrictedReturnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::remove($defaultReturnType, new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if ($this->isBitwiseOrWithJsonThrowOnError($optionsExpr)) {
            return $constrictedReturnType;
        }
        $valueType = $scope->getType($optionsExpr);
        if (!$valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $value = $valueType->getValue();
        $throwOnErrorType = $this->reflectionProvider->getConstant(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null)->getValueType();
        if (!$throwOnErrorType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $throwOnErrorValue = $throwOnErrorType->getValue();
        if (($value & $throwOnErrorValue) !== $throwOnErrorValue) {
            return $defaultReturnType;
        }
        return $constrictedReturnType;
    }
    private function isBitwiseOrWithJsonThrowOnError(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch && $expr->name->toCodeString() === '\\JSON_THROW_ON_ERROR') {
            return \true;
        }
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BitwiseOr) {
            return \false;
        }
        return $this->isBitwiseOrWithJsonThrowOnError($expr->left) || $this->isBitwiseOrWithJsonThrowOnError($expr->right);
    }
}
