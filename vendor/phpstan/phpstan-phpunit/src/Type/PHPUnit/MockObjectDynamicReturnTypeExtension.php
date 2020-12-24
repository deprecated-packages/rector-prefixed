<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\PHPUnit;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName || $type->getClassName() !== \_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericObjectType(\_PhpScoper0a6b37af0871\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
