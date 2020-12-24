<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use SimpleXMLElement;
class SimpleXMLElementAsXMLMethodReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \SimpleXMLElement::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'asXML';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
    }
}
