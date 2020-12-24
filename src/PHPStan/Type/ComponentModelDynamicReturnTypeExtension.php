<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PHPStan\Type;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
/**
 * @copied from https://github.com/phpstan/phpstan-nette/blob/master/src/Type/Nette/ComponentModelDynamicReturnTypeExtension.php
 */
final class ComponentModelDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScoper0a6b37af0871\\Nette\\ComponentModel\\Container';
    }
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getComponent';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $calledOnType = $scope->getType($methodCall->var);
        $mixedType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        $args = $methodCall->args;
        if (\count($args) !== 1) {
            return $mixedType;
        }
        $argType = $scope->getType($args[0]->value);
        if (!$argType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            return $mixedType;
        }
        $methodName = \sprintf('createComponent%s', \ucfirst($argType->getValue()));
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return $mixedType;
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
