<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticTypeFactory;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class ArrayFilterFunctionReturnTypeReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_filter';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        $callbackArg = $functionCall->args[1]->value ?? null;
        $flagArg = $functionCall->args[2]->value ?? null;
        if ($arrayArg !== null) {
            $arrayArgType = $scope->getType($arrayArg);
            $keyType = $arrayArgType->getIterableKeyType();
            $itemType = $arrayArgType->getIterableValueType();
            if ($arrayArgType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType()), new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType()]);
            }
            if ($callbackArg === null) {
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map([$this, 'removeFalsey'], \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getArrays($arrayArgType)));
            }
            if ($flagArg === null && $callbackArg instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure && \count($callbackArg->stmts) === 1) {
                $statement = $callbackArg->stmts[0];
                if ($statement instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ && $statement->expr !== null && \count($callbackArg->params) > 0) {
                    if (!$callbackArg->params[0]->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || !\is_string($callbackArg->params[0]->var->name)) {
                        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
                    }
                    $itemVariableName = $callbackArg->params[0]->var->name;
                    if (!$scope instanceof \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope) {
                        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
                    }
                    $scope = $scope->assignVariable($itemVariableName, $itemType);
                    $scope = $scope->filterByTruthyValue($statement->expr);
                    $itemType = $scope->getVariableType($itemVariableName);
                }
            }
        } else {
            $keyType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
            $itemType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType($keyType, $itemType);
    }
    public function removeFalsey(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $falseyTypes = \_PhpScoperb75b35f52b74\PHPStan\Type\StaticTypeFactory::falsey();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
            $keys = $type->getKeyTypes();
            $values = $type->getValueTypes();
            $builder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($values as $offset => $value) {
                $isFalsey = $falseyTypes->isSuperTypeOf($value);
                if ($isFalsey->maybe()) {
                    $builder->setOffsetValueType($keys[$offset], \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::remove($value, $falseyTypes), \true);
                } elseif ($isFalsey->no()) {
                    $builder->setOffsetValueType($keys[$offset], $value);
                }
            }
            return $builder->getArray();
        }
        $keyType = $type->getIterableKeyType();
        $valueType = $type->getIterableValueType();
        $valueType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::remove($valueType, $falseyTypes);
        if ($valueType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType([], []);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType($keyType, $valueType);
    }
}
