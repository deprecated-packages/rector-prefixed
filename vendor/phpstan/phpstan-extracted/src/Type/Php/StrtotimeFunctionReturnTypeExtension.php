<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class StrtotimeFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'strtotime';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            return $defaultReturnType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($argType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $result = \array_unique(\array_map(static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType $string) : bool {
            return \is_int(\strtotime($string->getValue()));
        }, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantStrings($argType)));
        if (\count($result) !== 1) {
            return $defaultReturnType;
        }
        return $result[0] ? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType() : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
