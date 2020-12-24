<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Psr\Container\ContainerInterface;
final class StaticContainerGetDynamicMethodReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScopere8e811afab72\Psr\Container\ContainerInterface::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $value = $methodCall->args[0]->value;
        $valueType = $scope->getType($value);
        // we don't know what it is
        if ($valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return $valueType;
        }
        if ($valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($valueType->getValue());
        }
        // unknown, probably variable
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
