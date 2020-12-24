<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\PHPUnit;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject;
class MockObjectDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'expects';
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $scope->getType($methodCall->var);
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        $mockClasses = \array_values(\array_filter($type->getTypes(), function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
            return !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName || $type->getClassName() !== \_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\MockObject::class;
        }));
        if (\count($mockClasses) !== 1) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType(\_PhpScoperb75b35f52b74\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class, $mockClasses);
    }
}
