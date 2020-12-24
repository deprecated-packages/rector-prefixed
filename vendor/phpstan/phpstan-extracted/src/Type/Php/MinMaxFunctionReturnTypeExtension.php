<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class MinMaxFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var string[] */
    private $functionNames = ['min' => '', 'max' => ''];
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return isset($this->functionNames[$functionReflection->getName()]);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[0])) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        if (\count($functionCall->args) === 1) {
            $argType = $scope->getType($functionCall->args[0]->value);
            if ($argType->isArray()->yes()) {
                $isIterable = $argType->isIterableAtLeastOnce();
                if ($isIterable->no()) {
                    return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
                $iterableValueType = $argType->getIterableValueType();
                $argumentTypes = [];
                if (!$isIterable->yes()) {
                    $argumentTypes[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
                }
                if ($iterableValueType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                    foreach ($iterableValueType->getTypes() as $innerType) {
                        $argumentTypes[] = $innerType;
                    }
                } else {
                    $argumentTypes[] = $iterableValueType;
                }
                return $this->processType($functionReflection->getName(), $argumentTypes);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
        }
        $argumentTypes = [];
        foreach ($functionCall->args as $arg) {
            $argType = $scope->getType($arg->value);
            if ($arg->unpack) {
                $iterableValueType = $argType->getIterableValueType();
                if ($iterableValueType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                    foreach ($iterableValueType->getTypes() as $innerType) {
                        $argumentTypes[] = $innerType;
                    }
                } else {
                    $argumentTypes[] = $iterableValueType;
                }
                continue;
            }
            $argumentTypes[] = $argType;
        }
        return $this->processType($functionReflection->getName(), $argumentTypes);
    }
    /**
     * @param string $functionName
     * @param \PHPStan\Type\Type[] $types
     * @return Type
     */
    private function processType(string $functionName, array $types) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $resultType = null;
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType) {
                return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$types);
            }
            if ($resultType === null) {
                $resultType = $type;
                continue;
            }
            $compareResult = $this->compareTypes($resultType, $type);
            if ($functionName === 'min') {
                if ($compareResult === $type) {
                    $resultType = $type;
                }
            } elseif ($functionName === 'max') {
                if ($compareResult === $resultType) {
                    $resultType = $type;
                }
            }
        }
        if ($resultType === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType();
        }
        return $resultType;
    }
    private function compareTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $firstType, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $secondType) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($firstType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $secondType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType) {
            return $secondType;
        }
        if ($firstType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && $secondType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            return $firstType;
        }
        if ($firstType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType && $secondType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            if ($secondType->count() < $firstType->count()) {
                return $secondType;
            } elseif ($firstType->count() < $secondType->count()) {
                return $firstType;
            }
            foreach ($firstType->getValueTypes() as $i => $firstValueType) {
                $secondValueType = $secondType->getValueTypes()[$i];
                $compareResult = $this->compareTypes($firstValueType, $secondValueType);
                if ($compareResult === $firstValueType) {
                    return $firstType;
                }
                if ($compareResult === $secondValueType) {
                    return $secondType;
                }
            }
            return null;
        }
        if ($firstType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && $secondType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType) {
            if ($secondType->getValue() < $firstType->getValue()) {
                return $secondType;
            }
            if ($firstType->getValue() < $secondType->getValue()) {
                return $firstType;
            }
        }
        return null;
    }
}
