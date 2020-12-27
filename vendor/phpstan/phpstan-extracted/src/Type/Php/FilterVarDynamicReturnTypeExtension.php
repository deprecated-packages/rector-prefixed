<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class FilterVarDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var ConstantStringType */
    private $flagsString;
    /** @var array<int, Type>|null */
    private $filterTypeMap = null;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->flagsString = new \PHPStan\Type\Constant\ConstantStringType('flags');
    }
    /**
     * @return array<int, Type>
     */
    private function getFilterTypeMap() : array
    {
        if ($this->filterTypeMap !== null) {
            return $this->filterTypeMap;
        }
        $booleanType = new \PHPStan\Type\BooleanType();
        $floatType = new \PHPStan\Type\FloatType();
        $intType = new \PHPStan\Type\IntegerType();
        $stringType = new \PHPStan\Type\StringType();
        $this->filterTypeMap = [$this->getConstant('FILTER_UNSAFE_RAW') => $stringType, $this->getConstant('FILTER_SANITIZE_EMAIL') => $stringType, $this->getConstant('FILTER_SANITIZE_ENCODED') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_FLOAT') => $stringType, $this->getConstant('FILTER_SANITIZE_NUMBER_INT') => $stringType, $this->getConstant('FILTER_SANITIZE_SPECIAL_CHARS') => $stringType, $this->getConstant('FILTER_SANITIZE_STRING') => $stringType, $this->getConstant('FILTER_SANITIZE_URL') => $stringType, $this->getConstant('FILTER_VALIDATE_BOOLEAN') => $booleanType, $this->getConstant('FILTER_VALIDATE_EMAIL') => $stringType, $this->getConstant('FILTER_VALIDATE_FLOAT') => $floatType, $this->getConstant('FILTER_VALIDATE_INT') => $intType, $this->getConstant('FILTER_VALIDATE_IP') => $stringType, $this->getConstant('FILTER_VALIDATE_MAC') => $stringType, $this->getConstant('FILTER_VALIDATE_REGEXP') => $stringType, $this->getConstant('FILTER_VALIDATE_URL') => $stringType];
        if ($this->reflectionProvider->hasConstant(new \PhpParser\Node\Name('FILTER_SANITIZE_MAGIC_QUOTES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_MAGIC_QUOTES')] = $stringType;
        }
        if ($this->reflectionProvider->hasConstant(new \PhpParser\Node\Name('FILTER_SANITIZE_ADD_SLASHES'), null)) {
            $this->filterTypeMap[$this->getConstant('FILTER_SANITIZE_ADD_SLASHES')] = $stringType;
        }
        return $this->filterTypeMap;
    }
    private function getConstant(string $constantName) : int
    {
        $constant = $this->reflectionProvider->getConstant(new \PhpParser\Node\Name($constantName), null);
        $valueType = $constant->getValueType();
        if (!$valueType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf('Constant %s does not have integer type.', $constantName));
        }
        return $valueType->getValue();
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \strtolower($functionReflection->getName()) === 'filter_var';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $mixedType = new \PHPStan\Type\MixedType();
        $filterArg = $functionCall->args[1] ?? null;
        if ($filterArg === null) {
            $filterValue = $this->getConstant('FILTER_DEFAULT');
        } else {
            $filterType = $scope->getType($filterArg->value);
            if (!$filterType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
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
                $type = new \PHPStan\Type\UnionType([$type, $otherType]);
            }
        }
        if ($this->hasFlag($this->getConstant('FILTER_FORCE_ARRAY'), $flagsArg, $scope)) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $type);
        }
        return $type;
    }
    private function determineExactType(\PHPStan\Type\Type $in, int $filterValue) : ?\PHPStan\Type\Type
    {
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_BOOLEAN') && $in instanceof \PHPStan\Type\BooleanType || $filterValue === $this->getConstant('FILTER_VALIDATE_INT') && $in instanceof \PHPStan\Type\IntegerType || $filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \PHPStan\Type\FloatType) {
            return $in;
        }
        if ($filterValue === $this->getConstant('FILTER_VALIDATE_FLOAT') && $in instanceof \PHPStan\Type\IntegerType) {
            return $in->toFloat();
        }
        return null;
    }
    private function getOtherType(?\PhpParser\Node\Arg $flagsArg, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $falseType = new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        if ($flagsArg === null) {
            return $falseType;
        }
        $defaultType = $this->getDefault($flagsArg, $scope);
        if ($defaultType !== null) {
            return $defaultType;
        }
        if ($this->hasFlag($this->getConstant('FILTER_NULL_ON_FAILURE'), $flagsArg, $scope)) {
            return new \PHPStan\Type\NullType();
        }
        return $falseType;
    }
    private function getDefault(\PhpParser\Node\Arg $expression, \PHPStan\Analyser\Scope $scope) : ?\PHPStan\Type\Type
    {
        $exprType = $scope->getType($expression->value);
        if (!$exprType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $optionsType = $exprType->getOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType('options'));
        if (!$optionsType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return null;
        }
        $defaultType = $optionsType->getOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType('default'));
        if (!$defaultType instanceof \PHPStan\Type\ErrorType) {
            return $defaultType;
        }
        return null;
    }
    private function hasFlag(int $flag, ?\PhpParser\Node\Arg $expression, \PHPStan\Analyser\Scope $scope) : bool
    {
        if ($expression === null) {
            return \false;
        }
        $type = $this->getFlagsValue($scope->getType($expression->value));
        return $type instanceof \PHPStan\Type\Constant\ConstantIntegerType && ($type->getValue() & $flag) === $flag;
    }
    private function getFlagsValue(\PHPStan\Type\Type $exprType) : \PHPStan\Type\Type
    {
        if (!$exprType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return $exprType;
        }
        return $exprType->getOffsetValueType($this->flagsString);
    }
}
