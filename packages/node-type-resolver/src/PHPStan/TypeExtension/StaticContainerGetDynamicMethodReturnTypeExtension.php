<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Psr\Container\ContainerInterface;
final class StaticContainerGetDynamicMethodReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\Psr\Container\ContainerInterface::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get';
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $value = $methodCall->args[0]->value;
        $valueType = $scope->getType($value);
        // we don't know what it is
        if ($valueType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return $valueType;
        }
        if ($valueType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($valueType->getValue());
        }
        // unknown, probably variable
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
