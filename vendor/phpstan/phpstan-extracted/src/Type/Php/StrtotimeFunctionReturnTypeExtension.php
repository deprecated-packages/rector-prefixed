<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class StrtotimeFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'strtotime';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            return $defaultReturnType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($argType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::toBenevolentUnion($defaultReturnType);
        }
        $result = \array_unique(\array_map(static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType $string) : bool {
            return \is_int(\strtotime($string->getValue()));
        }, \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($argType)));
        if (\count($result) !== 1) {
            return $defaultReturnType;
        }
        return $result[0] ? new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType() : new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
