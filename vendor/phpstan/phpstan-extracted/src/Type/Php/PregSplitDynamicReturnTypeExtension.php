<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class PregSplitDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \strtolower($functionReflection->getName()) === 'preg_split';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $flagsArg = $functionCall->args[3] ?? null;
        if ($this->hasFlag($this->getConstant('PREG_SPLIT_OFFSET_CAPTURE'), $flagsArg, $scope)) {
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]));
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($type, new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
    }
    private function hasFlag(int $flag, ?\_PhpScopere8e811afab72\PhpParser\Node\Arg $expression, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        if ($expression === null) {
            return \false;
        }
        $type = $scope->getType($expression->value);
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && ($type->getValue() & $flag) === $flag;
    }
    private function getConstant(string $constantName) : int
    {
        $constant = $this->reflectionProvider->getConstant(new \_PhpScopere8e811afab72\PhpParser\Node\Name($constantName), null);
        $valueType = $constant->getValueType();
        if (!$valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Constant %s does not have integer type.', $constantName));
        }
        return $valueType->getValue();
    }
}
