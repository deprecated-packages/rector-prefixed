<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class PowFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pow';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $defaultReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType()]);
        if (\count($functionCall->args) < 2) {
            return $defaultReturnType;
        }
        $firstArgType = $scope->getType($functionCall->args[0]->value);
        $secondArgType = $scope->getType($functionCall->args[1]->value);
        if ($firstArgType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType || $secondArgType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return $defaultReturnType;
        }
        $object = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType();
        if (!$object->isSuperTypeOf($firstArgType)->no() || !$object->isSuperTypeOf($secondArgType)->no()) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($firstArgType, $secondArgType);
        }
        return $defaultReturnType;
    }
}
