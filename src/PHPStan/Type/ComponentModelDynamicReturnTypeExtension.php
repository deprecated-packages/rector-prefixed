<?php

declare (strict_types=1);
namespace Rector\Core\PHPStan\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
/**
 * @copied from https://github.com/phpstan/phpstan-nette/blob/master/src/Type/Nette/ComponentModelDynamicReturnTypeExtension.php
 */
final class ComponentModelDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScoperabd03f0baf05\\Nette\\ComponentModel\\Container';
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getComponent';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $calledOnType = $scope->getType($methodCall->var);
        $mixedType = new \PHPStan\Type\MixedType();
        $args = $methodCall->args;
        if (\count($args) !== 1) {
            return $mixedType;
        }
        $argType = $scope->getType($args[0]->value);
        if (!$argType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return $mixedType;
        }
        $methodName = \sprintf('createComponent%s', \ucfirst($argType->getValue()));
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return $mixedType;
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
