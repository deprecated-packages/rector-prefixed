<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\NullType;
use PHPStan\Type\StaticTypeFactory;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArrayFilterFunctionReturnTypeReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_filter';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        $callbackArg = $functionCall->args[1]->value ?? null;
        $flagArg = $functionCall->args[2]->value ?? null;
        if ($arrayArg !== null) {
            $arrayArgType = $scope->getType($arrayArg);
            $keyType = $arrayArgType->getIterableKeyType();
            $itemType = $arrayArgType->getIterableValueType();
            if ($arrayArgType instanceof \PHPStan\Type\MixedType) {
                return new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\NullType()]);
            }
            if ($callbackArg === null) {
                return \PHPStan\Type\TypeCombinator::union(...\array_map([$this, 'removeFalsey'], \PHPStan\Type\TypeUtils::getArrays($arrayArgType)));
            }
            if ($flagArg === null && $callbackArg instanceof \PhpParser\Node\Expr\Closure && \count($callbackArg->stmts) === 1) {
                $statement = $callbackArg->stmts[0];
                if ($statement instanceof \PhpParser\Node\Stmt\Return_ && $statement->expr !== null && \count($callbackArg->params) > 0) {
                    if (!$callbackArg->params[0]->var instanceof \PhpParser\Node\Expr\Variable || !\is_string($callbackArg->params[0]->var->name)) {
                        throw new \PHPStan\ShouldNotHappenException();
                    }
                    $itemVariableName = $callbackArg->params[0]->var->name;
                    if (!$scope instanceof \PHPStan\Analyser\MutatingScope) {
                        throw new \PHPStan\ShouldNotHappenException();
                    }
                    $scope = $scope->assignVariable($itemVariableName, $itemType);
                    $scope = $scope->filterByTruthyValue($statement->expr);
                    $itemType = $scope->getVariableType($itemVariableName);
                }
            }
        } else {
            $keyType = new \PHPStan\Type\MixedType();
            $itemType = new \PHPStan\Type\MixedType();
        }
        return new \PHPStan\Type\ArrayType($keyType, $itemType);
    }
    public function removeFalsey(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        $falseyTypes = \PHPStan\Type\StaticTypeFactory::falsey();
        if ($type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            $keys = $type->getKeyTypes();
            $values = $type->getValueTypes();
            $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($values as $offset => $value) {
                $isFalsey = $falseyTypes->isSuperTypeOf($value);
                if ($isFalsey->maybe()) {
                    $builder->setOffsetValueType($keys[$offset], \PHPStan\Type\TypeCombinator::remove($value, $falseyTypes), \true);
                } elseif ($isFalsey->no()) {
                    $builder->setOffsetValueType($keys[$offset], $value);
                }
            }
            return $builder->getArray();
        }
        $keyType = $type->getIterableKeyType();
        $valueType = $type->getIterableValueType();
        $valueType = \PHPStan\Type\TypeCombinator::remove($valueType, $falseyTypes);
        if ($valueType instanceof \PHPStan\Type\NeverType) {
            return new \PHPStan\Type\Constant\ConstantArrayType([], []);
        }
        return new \PHPStan\Type\ArrayType($keyType, $valueType);
    }
}
