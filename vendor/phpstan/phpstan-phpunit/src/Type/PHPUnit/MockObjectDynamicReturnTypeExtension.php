<?php

declare (strict_types=1);
namespace PHPStan\Type\PHPUnit;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use RectorPrefix20201227\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use RectorPrefix20201227\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \RectorPrefix20201227\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \PHPStan\Type\IntersectionType) {
            return new \PHPStan\Type\ObjectType(\RectorPrefix20201227\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \PHPStan\Type\TypeWithClassName || $type->getClassName() !== \RectorPrefix20201227\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \PHPStan\Type\ObjectType(\RectorPrefix20201227\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \PHPStan\Type\Generic\GenericObjectType(\RectorPrefix20201227\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
