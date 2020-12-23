<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
final class ArraySearchFunctionDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_search';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount < 2) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $haystackArgType = $scope->getType($functionCall->args[1]->value);
        $haystackIsArray = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType()))->isSuperTypeOf($haystackArgType);
        if ($haystackIsArray->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
        }
        if ($argsCount < 3) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $strictArgType = $scope->getType($functionCall->args[2]->value);
        if (!$strictArgType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false), new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType());
        } elseif ($strictArgType->getValue() === \false) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($haystackArgType->getIterableKeyType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        $needleArgType = $scope->getType($functionCall->args[0]->value);
        if ($haystackArgType->getIterableValueType()->isSuperTypeOf($needleArgType)->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $typesFromConstantArrays = [];
        if ($haystackIsArray->maybe()) {
            $typesFromConstantArrays[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
        }
        $haystackArrays = $this->pickArrays($haystackArgType);
        if (\count($haystackArrays) === 0) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $arrays = [];
        $typesFromConstantArraysCount = 0;
        foreach ($haystackArrays as $haystackArray) {
            if (!$haystackArray instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
                $arrays[] = $haystackArray;
                continue;
            }
            $typesFromConstantArrays[] = $this->resolveTypeFromConstantHaystackAndNeedle($needleArgType, $haystackArray);
            $typesFromConstantArraysCount++;
        }
        if ($typesFromConstantArraysCount > 0 && \count($haystackArrays) === $typesFromConstantArraysCount) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$typesFromConstantArrays);
        }
        $iterableKeyType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$arrays)->getIterableKeyType();
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($iterableKeyType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false), ...$typesFromConstantArrays);
    }
    private function resolveTypeFromConstantHaystackAndNeedle(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $needle, \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType $haystack) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $matchesByType = [];
        foreach ($haystack->getValueTypes() as $index => $valueType) {
            $isNeedleSuperType = $valueType->isSuperTypeOf($needle);
            if ($isNeedleSuperType->no()) {
                $matchesByType[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
                continue;
            }
            if ($needle instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantScalarType && $valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantScalarType && $needle->getValue() === $valueType->getValue()) {
                return $haystack->getKeyTypes()[$index];
            }
            $matchesByType[] = $haystack->getKeyTypes()[$index];
            if (!$isNeedleSuperType->maybe()) {
                continue;
            }
            $matchesByType[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (\count($matchesByType) > 0) {
            if ($haystack->getIterableValueType()->accepts($needle, \true)->yes() && $needle->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType())->no()) {
                return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$matchesByType);
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false), ...$matchesByType);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
    /**
     * @param Type $type
     * @return Type[]
     */
    private function pickArrays(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : array
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return [$type];
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            $arrayTypes = [];
            foreach ($type->getTypes() as $innerType) {
                if (!$innerType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                    continue;
                }
                $arrayTypes[] = $innerType;
            }
            return $arrayTypes;
        }
        return [];
    }
}
