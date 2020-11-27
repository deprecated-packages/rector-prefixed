<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
final class ArraySearchFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_search';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount < 2) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $haystackArgType = $scope->getType($functionCall->args[1]->value);
        $haystackIsArray = (new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()))->isSuperTypeOf($haystackArgType);
        if ($haystackIsArray->no()) {
            return new \PHPStan\Type\NullType();
        }
        if ($argsCount < 3) {
            return \PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $strictArgType = $scope->getType($functionCall->args[2]->value);
        if (!$strictArgType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return \PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\NullType());
        } elseif ($strictArgType->getValue() === \false) {
            return \PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $needleArgType = $scope->getType($functionCall->args[0]->value);
        if ($haystackArgType->getIterableValueType()->isSuperTypeOf($needleArgType)->no()) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $typesFromConstantArrays = [];
        if ($haystackIsArray->maybe()) {
            $typesFromConstantArrays[] = new \PHPStan\Type\NullType();
        }
        $haystackArrays = $this->pickArrays($haystackArgType);
        if (\count($haystackArrays) === 0) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $arrays = [];
        $typesFromConstantArraysCount = 0;
        foreach ($haystackArrays as $haystackArray) {
            if (!$haystackArray instanceof \PHPStan\Type\Constant\ConstantArrayType) {
                $arrays[] = $haystackArray;
                continue;
            }
            $typesFromConstantArrays[] = $this->resolveTypeFromConstantHaystackAndNeedle($needleArgType, $haystackArray);
            $typesFromConstantArraysCount++;
        }
        if ($typesFromConstantArraysCount > 0 && \count($haystackArrays) === $typesFromConstantArraysCount) {
            return \PHPStan\Type\TypeCombinator::union(...$typesFromConstantArrays);
        }
        $iterableKeyType = \PHPStan\Type\TypeCombinator::union(...$arrays)->getIterableKeyType();
        return \PHPStan\Type\TypeCombinator::union($iterableKeyType, new \PHPStan\Type\Constant\ConstantBooleanType(\false), ...$typesFromConstantArrays);
    }
    private function resolveTypeFromConstantHaystackAndNeedle(\PHPStan\Type\Type $needle, \PHPStan\Type\Constant\ConstantArrayType $haystack) : \PHPStan\Type\Type
    {
        $matchesByType = [];
        foreach ($haystack->getValueTypes() as $index => $valueType) {
            $isNeedleSuperType = $valueType->isSuperTypeOf($needle);
            if ($isNeedleSuperType->no()) {
                $matchesByType[] = new \PHPStan\Type\Constant\ConstantBooleanType(\false);
                continue;
            }
            if ($needle instanceof \PHPStan\Type\ConstantScalarType && $valueType instanceof \PHPStan\Type\ConstantScalarType && $needle->getValue() === $valueType->getValue()) {
                return $haystack->getKeyTypes()[$index];
            }
            $matchesByType[] = $haystack->getKeyTypes()[$index];
            if (!$isNeedleSuperType->maybe()) {
                continue;
            }
            $matchesByType[] = new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (\count($matchesByType) > 0) {
            if ($haystack->getIterableValueType()->accepts($needle, \true)->yes() && $needle->isSuperTypeOf(new \PHPStan\Type\ObjectWithoutClassType())->no()) {
                return \PHPStan\Type\TypeCombinator::union(...$matchesByType);
            }
            return \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantBooleanType(\false), ...$matchesByType);
        }
        return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    /**
     * @param Type $type
     * @return Type[]
     */
    private function pickArrays(\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \PHPStan\Type\ArrayType) {
            return [$type];
        }
        if ($type instanceof \PHPStan\Type\UnionType || $type instanceof \PHPStan\Type\IntersectionType) {
            $arrayTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \PHPStan\Type\ArrayType) {
                    continue;
                }
                $arrayTypes[] = $innerType;
            }
            return $arrayTypes;
        }
        return [];
    }
}
