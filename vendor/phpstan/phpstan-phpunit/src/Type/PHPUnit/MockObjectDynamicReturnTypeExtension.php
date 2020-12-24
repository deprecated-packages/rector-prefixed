<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\PHPUnit;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName || $type->getClassName() !== \_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType(\_PhpScopere8e811afab72\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
