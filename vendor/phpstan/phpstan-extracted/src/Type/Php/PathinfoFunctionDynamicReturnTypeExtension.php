<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class PathinfoFunctionDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pathinfo';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount === 0) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        } elseif ($argsCount === 1) {
            $stringType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType();
            $builder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createFromConstantArray(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType('dirname'), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType('basename'), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType('filename')], [$stringType, $stringType, $stringType]));
            $builder->setOffsetValueType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType('extension'), $stringType, \true);
            return $builder->getArray();
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType();
    }
}
