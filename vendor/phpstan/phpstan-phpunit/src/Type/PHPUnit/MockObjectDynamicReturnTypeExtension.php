<?php

declare (strict_types=1);
namespace PHPStan\Type\PHPUnit;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use _PhpScoper17db12703726\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoper17db12703726\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper17db12703726\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \PHPStan\Type\IntersectionType) {
            return new \PHPStan\Type\ObjectType(\_PhpScoper17db12703726\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \PHPStan\Type\TypeWithClassName || $type->getClassName() !== \_PhpScoper17db12703726\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \PHPStan\Type\ObjectType(\_PhpScoper17db12703726\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \PHPStan\Type\Generic\GenericObjectType(\_PhpScoper17db12703726\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
