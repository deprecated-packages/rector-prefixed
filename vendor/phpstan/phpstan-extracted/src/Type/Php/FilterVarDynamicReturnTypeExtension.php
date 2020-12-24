<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class FilterVarDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var ConstantStringType */
    private $flagsString;
    /** @var array<int, Type>|null */
    private $filterTypeMap = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->flagsString = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('flags');
    }
    /**
     * @return array<int, Type>
     */
    private function getFilterTypeMap() : array
    {
        if ($this->filterTypeMap !== null) {
            return $this->filterTypeMap;
        }
        $booleanType = new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        $floatType = new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
        $intType = new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        $stringType = new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
        $this->filterTypeMap = [$this->getConstant('FILTER_UNSAFE_RAW') => $stringType, $this->getConstant('FILTER_SANITIZE_EMAIL') => $stringType, $this->getConstant('FILTER_SANITIZE_ENCODED') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_FLOAT') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_INT') => $stringType, $this->getConstant('FILTER_SANITIZE_SPECIAL_CHARS') => $stringType, $this->getConstant('FILTER_SANITIZE_STRING') => $stringType, $this->getConstant('FILTER_SANITIZE_URL') => $stringType, $this->getConstant('FILTER_VALIDATE_BOOLEAN') => $booleanType, $this->getConstant('FILTER_VALIDATE_EMAIL') => $stringType, $this->getConstant('FILTER_VALIDATE_FLOAT') => $floatType, $this->getConstant('FILTER_VALIDATE_INT') => $intType, $this->getConstant('FILTER_VALIDATE_IP') => $stringType, $this->getConstant('FILTER_VALIDATE_MAC') => $stringType, $this->getConstant('FILTER_VALIDATE_REGEXP') => $stringType, $this->getConstant('FILTER_VALIDATE_URL') => $stringType];
        if ($this->reflectionProvider->hasConstant(new \_PhpScopere8e811afab72\PhpParser\Node\Name('FILTER_SANITIZE_MAGIC_QUOTES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_MAGIC_QUOTES')] = $stringType;
        }
        if ($this->reflectionProvider->hasConstant(new \_PhpScopere8e811afab72\PhpParser\Node\Name('FILTER_SANITIZE_ADD_SLASHES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_ADD_SLASHES')] = $stringType;
        }
        return $this->filterTypeMap;
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
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \strtolower($functionReflection->getName()) === 'filter_var';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $mixedType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        $filterArg = $functionCall->args[1] ?? null;
        if ($filterArg === null) {
            $filterValue = $this->getConstant('FILTER_DEFAULT');
        } else {
            $filterType = $scope->getType($filterArg->value);
            if (!$filterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                return $mixedType;
            }
            $filterValue = $filterType->getValue();
        }
        $flagsArg = $functionCall->args[2] ?? null;
        $inputType = $scope->getType($functionCall->args[0]->value);
        $exactType = $this->determineExactType($inputType, $filterValue);
        if ($exactType !== null) {
            $type = $exactType;
        } else {
            $type = $this->getFilterTypeMap()[$filterValue] ?? $mixedType;
            $otherType = $this->getOtherType($flagsArg, $scope);
            if ($otherType->isSuperTypeOf($type)->no()) {
                $type = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$type, $otherType]);
            }
        }
        if ($this->hasFlag($this->getConstant('FILTER_FORCE_ARRAY'), $flagsArg, $scope)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $type);
        }
        return $type;
    }
    private function determineExactType(\_PhpScopere8e811afab72\PHPStan\Type\Type $in, int $filterValue) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_BOOLEAN') && $in instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType || $filterValue === $this->getConstant('FILTER_VALIDATE_INT') && $in instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType || $filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType) {
            return $in;
        }
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType) {
            return $in->toFloat();
        }
        return null;
    }
    private function getOtherType(?\_PhpScopere8e811afab72\PhpParser\Node\Arg $flagsArg, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $falseType = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        if ($flagsArg === null) {
            return $falseType;
        }
        $defaultType = $this->getDefault($flagsArg, $scope);
        if ($defaultType !== null) {
            return $defaultType;
        }
        if ($this->hasFlag($this->getConstant('FILTER_NULL_ON_FAILURE'), $flagsArg, $scope)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        return $falseType;
    }
    private function getDefault(\_PhpScopere8e811afab72\PhpParser\Node\Arg $expression, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $exprType = $scope->getType($expression->value);
        if (!$exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $optionsType = $exprType->getOffsetValueType(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('options'));
        if (!$optionsType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $defaultType = $optionsType->getOffsetValueType(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('default'));
        if (!$defaultType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType) {
            return $defaultType;
        }
        return null;
    }
    private function hasFlag(int $flag, ?\_PhpScopere8e811afab72\PhpParser\Node\Arg $expression, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        if ($expression === null) {
            return \false;
        }
        $type = $this->getFlagsValue($scope->getType($expression->value));
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && ($type->getValue() & $flag) === $flag;
    }
    private function getFlagsValue(\_PhpScopere8e811afab72\PHPStan\Type\Type $exprType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $exprType;
        }
        return $exprType->getOffsetValueType($this->flagsString);
    }
}
