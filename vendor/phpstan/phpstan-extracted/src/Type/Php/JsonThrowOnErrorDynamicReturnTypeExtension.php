<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class JsonThrowOnErrorDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var array<string, int> */
    private $argumentPositions = ['json_encode' => 1, 'json_decode' => 3];
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $this->reflectionProvider->hasConstant(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null) && \in_array($functionReflection->getName(), ['json_encode', 'json_decode'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $argumentPosition = $this->argumentPositions[$functionReflection->getName()];
        $defaultReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (!isset($functionCall->args[$argumentPosition])) {
            return $defaultReturnType;
        }
        $optionsExpr = $functionCall->args[$argumentPosition]->value;
        $constrictedReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::remove($defaultReturnType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if ($this->isBitwiseOrWithJsonThrowOnError($optionsExpr)) {
            return $constrictedReturnType;
        }
        $valueType = $scope->getType($optionsExpr);
        if (!$valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $value = $valueType->getValue();
        $throwOnErrorType = $this->reflectionProvider->getConstant(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('JSON_THROW_ON_ERROR'), null)->getValueType();
        if (!$throwOnErrorType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType) {
            return $defaultReturnType;
        }
        $throwOnErrorValue = $throwOnErrorType->getValue();
        if (($value & $throwOnErrorValue) !== $throwOnErrorValue) {
            return $defaultReturnType;
        }
        return $constrictedReturnType;
    }
    private function isBitwiseOrWithJsonThrowOnError(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ConstFetch && $expr->name->toCodeString() === '\\JSON_THROW_ON_ERROR') {
            return \true;
        }
        if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BitwiseOr) {
            return \false;
        }
        return $this->isBitwiseOrWithJsonThrowOnError($expr->left) || $this->isBitwiseOrWithJsonThrowOnError($expr->right);
    }
}
