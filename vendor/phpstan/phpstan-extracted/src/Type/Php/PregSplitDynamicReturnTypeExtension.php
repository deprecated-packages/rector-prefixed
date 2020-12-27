<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class PregSplitDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \strtolower($functionReflection->getName()) === 'preg_split';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $flagsArg = $functionCall->args[3] ?? null;
        if ($this->hasFlag($this->getConstant('PREG_SPLIT_OFFSET_CAPTURE'), $flagsArg, $scope)) {
            $type = new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]));
            return \PHPStan\Type\TypeCombinator::union($type, new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
    }
    private function hasFlag(int $flag, ?\PhpParser\Node\Arg $expression, \PHPStan\Analyser\Scope $scope) : bool
    {
        if ($expression === null) {
            return \false;
        }
        $type = $scope->getType($expression->value);
        return $type instanceof \PHPStan\Type\Constant\ConstantIntegerType && ($type->getValue() & $flag) === $flag;
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
}
