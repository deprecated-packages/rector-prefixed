<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Psr\Container\ContainerInterface;
final class StaticContainerGetDynamicMethodReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a2ac50786fa\Psr\Container\ContainerInterface::class;
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $value = $methodCall->args[0]->value;
        $valueType = $scope->getType($value);
        // we don't know what it is
        if ($valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return $valueType;
        }
        if ($valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($valueType->getValue());
        }
        // unknown, probably variable
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
}
