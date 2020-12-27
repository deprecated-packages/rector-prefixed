<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use SimpleXMLElement;
class SimpleXMLElementAsXMLMethodReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \SimpleXMLElement::class;
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'asXML';
    }
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 1) {
            return new \PHPStan\Type\BooleanType();
        }
        return new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
    }
}
