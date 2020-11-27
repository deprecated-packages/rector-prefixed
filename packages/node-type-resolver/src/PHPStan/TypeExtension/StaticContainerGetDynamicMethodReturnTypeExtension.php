<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan\TypeExtension;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use _PhpScoperbd5d0c5f7638\Psr\Container\ContainerInterface;
final class StaticContainerGetDynamicMethodReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperbd5d0c5f7638\Psr\Container\ContainerInterface::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $value = $methodCall->args[0]->value;
        $valueType = $scope->getType($value);
        // we don't know what it is
        if ($valueType instanceof \PHPStan\Type\MixedType) {
            return $valueType;
        }
        if ($valueType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Type\ObjectType($valueType->getValue());
        }
        // unknown, probably variable
        return new \PHPStan\Type\MixedType();
    }
}
