<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BenevolentUnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
class PowFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pow';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $defaultReturnType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BenevolentUnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType()]);
        if (\count($functionCall->args) < 2) {
            return $defaultReturnType;
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($firstArgType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType || $secondArgType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return $defaultReturnType;
        }
        $object = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType();
        if (!$object->isSuperTypeOf($firstArgType)->no() || !$object->isSuperTypeOf($secondArgType)->no()) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($firstArgType, $secondArgType);
        }
        return $defaultReturnType;
    }
}
