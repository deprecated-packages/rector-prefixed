<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticTypeFactory;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ArrayFilterFunctionReturnTypeReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_filter';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        $callbackArg = $functionCall->args[1]->value ?? null;
        $flagArg = $functionCall->args[2]->value ?? null;
        if ($arrayArg !== null) {
            $arrayArgType = $scope->getType($arrayArg);
            $keyType = $arrayArgType->getIterableKeyType();
            $itemType = $arrayArgType->getIterableValueType();
            if ($arrayArgType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType()), new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType()]);
            }
            if ($callbackArg === null) {
                return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_map([$this, 'removeFalsey'], \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getArrays($arrayArgType)));
            }
            if ($flagArg === null && $callbackArg instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure && \count($callbackArg->stmts) === 1) {
                $statement = $callbackArg->stmts[0];
                if ($statement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ && $statement->expr !== null && \count($callbackArg->params) > 0) {
                    if (!$callbackArg->params[0]->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable || !\is_string($callbackArg->params[0]->var->name)) {
                        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
                    }
                    $itemVariableName = $callbackArg->params[0]->var->name;
                    if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope) {
                        throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
                    }
                    $scope = $scope->assignVariable($itemVariableName, $itemType);
                    $scope = $scope->filterByTruthyValue($statement->expr);
                    $itemType = $scope->getVariableType($itemVariableName);
                }
            }
        } else {
            $keyType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
            $itemType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType($keyType, $itemType);
    }
    public function removeFalsey(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $falseyTypes = \_PhpScoper0a6b37af0871\PHPStan\Type\StaticTypeFactory::falsey();
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType) {
            $keys = $type->getKeyTypes();
            $values = $type->getValueTypes();
            $builder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($values as $offset => $value) {
                $isFalsey = $falseyTypes->isSuperTypeOf($value);
                if ($isFalsey->maybe()) {
                    $builder->setOffsetValueType($keys[$offset], \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove($value, $falseyTypes), \true);
                } elseif ($isFalsey->no()) {
                    $builder->setOffsetValueType($keys[$offset], $value);
                }
            }
            return $builder->getArray();
        }
        $keyType = $type->getIterableKeyType();
        $valueType = $type->getIterableValueType();
        $valueType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove($valueType, $falseyTypes);
        if ($valueType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType([], []);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType($keyType, $valueType);
    }
}
