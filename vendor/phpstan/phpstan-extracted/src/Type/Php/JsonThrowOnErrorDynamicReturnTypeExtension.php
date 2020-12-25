<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name\FullyQualified;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class JsonThrowOnErrorDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $argumentPositions = ['json_encode' => 1, 'json_decode' => 3];
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $this->reflectionProvider->hasConstant(new \PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null) && \in_array($functionReflection->getName(), ['json_encode', 'json_decode'], \true);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argumentPosition = $this->argumentPositions[$functionReflection->getName()];
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (!isset($functionCall->args[$argumentPosition])) {
            return $defaultReturnType;
        }
        $optionsExpr = $functionCall->args[$argumentPosition]->value;
        $constrictedReturnType = \PHPStan\Type\TypeCombinator::remove($defaultReturnType, new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        if ($this->isBitwiseOrWithJsonThrowOnError($optionsExpr)) {
            return $constrictedReturnType;
        }
        $valueType = $scope->getType($optionsExpr);
        if (!$valueType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $value = $valueType->getValue();
        $throwOnErrorType = $this->reflectionProvider->getConstant(new \PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null)->getValueType();
        if (!$throwOnErrorType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $throwOnErrorValue = $throwOnErrorType->getValue();
        if (($value & $throwOnErrorValue) !== $throwOnErrorValue) {
            return $defaultReturnType;
        }
        return $constrictedReturnType;
    }
    private function isBitwiseOrWithJsonThrowOnError(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\ConstFetch && $expr->name->toCodeString() === '\\JSON_THROW_ON_ERROR') {
            return \true;
        }
        if (!$expr instanceof \PhpParser\Node\Expr\BinaryOp\BitwiseOr) {
            return \false;
        }
        return $this->isBitwiseOrWithJsonThrowOnError($expr->left) || $this->isBitwiseOrWithJsonThrowOnError($expr->right);
    }
}
