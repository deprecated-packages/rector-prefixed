<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\PHPUnit;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType(\_PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName || $type->getClassName() !== \_PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType(\_PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType(\_PhpScoper0a2ac50786fa\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
