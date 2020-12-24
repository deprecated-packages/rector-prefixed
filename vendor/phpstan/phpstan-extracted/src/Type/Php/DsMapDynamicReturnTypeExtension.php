<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
final class DsMapDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScoperb75b35f52b74\\Ds\\Map';
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get' || $methodReflection->getName() === 'remove';
    }
    public function getTypeFromMethodCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $returnType = $methodReflection->getVariants()[0]->getReturnType();
        if (\count($methodCall->args) > 1) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            $types = \array_values(\array_filter($returnType->getTypes(), static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool {
                return !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
            }));
            if (\count($types) === 1) {
                return $types[0];
            }
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $returnType;
    }
}
