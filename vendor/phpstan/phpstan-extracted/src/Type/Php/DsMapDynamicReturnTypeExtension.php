<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
final class DsMapDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScoper0a2ac50786fa\\Ds\\Map';
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get' || $methodReflection->getName() === 'remove';
    }
    public function getTypeFromMethodCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $returnType = $methodReflection->getVariants()[0]->getReturnType();
        if (\count($methodCall->args) > 1) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }
        if ($returnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            $types = \array_values(\array_filter($returnType->getTypes(), static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool {
                return !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
            }));
            if (\count($types) === 1) {
                return $types[0];
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $returnType;
    }
}
