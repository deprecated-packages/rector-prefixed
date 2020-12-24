<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
class PowFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pow';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $defaultReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType()]);
        if (\count($functionCall->args) < 2) {
            return $defaultReturnType;
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($firstArgType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType || $secondArgType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return $defaultReturnType;
        }
        $object = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
        if (!$object->isSuperTypeOf($firstArgType)->no() || !$object->isSuperTypeOf($secondArgType)->no()) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($firstArgType, $secondArgType);
        }
        return $defaultReturnType;
    }
}
