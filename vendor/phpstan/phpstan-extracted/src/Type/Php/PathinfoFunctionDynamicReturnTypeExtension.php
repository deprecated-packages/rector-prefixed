<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
class PathinfoFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'pathinfo';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount === 0) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        } elseif ($argsCount === 1) {
            $stringType = new \PHPStan\Type\StringType();
            $builder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createFromConstantArray(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('dirname'), new \PHPStan\Type\Constant\ConstantStringType('basename'), new \PHPStan\Type\Constant\ConstantStringType('filename')], [$stringType, $stringType, $stringType]));
            $builder->setOffsetValueType(new \PHPStan\Type\Constant\ConstantStringType('extension'), $stringType, \true);
            return $builder->getArray();
        }
        return new \PHPStan\Type\StringType();
    }
}
