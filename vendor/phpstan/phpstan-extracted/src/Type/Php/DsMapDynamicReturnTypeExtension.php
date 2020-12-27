<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
final class DsMapDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return 'RectorPrefix20201227\\Ds\\Map';
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get' || $methodReflection->getName() === 'remove';
    }
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $returnType = $methodReflection->getVariants()[0]->getReturnType();
        if (\count($methodCall->args) > 1) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }
        if ($returnType instanceof \PHPStan\Type\UnionType) {
            $types = \array_values(\array_filter($returnType->getTypes(), static function (\PHPStan\Type\Type $type) : bool {
                return !$type instanceof \PHPStan\Type\Generic\TemplateType;
            }));
            if (\count($types) === 1) {
                return $types[0];
            }
            return \PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $returnType;
    }
}
