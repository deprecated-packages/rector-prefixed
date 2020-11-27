<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\ReturnTypeExtension;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
final class PhpDocInfoGetByTypeReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getByType';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $returnType = $this->resolveArgumentValue($methodCall->args[0]->value);
        if ($returnType === null) {
            return new \PHPStan\Type\MixedType();
        }
        return new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType($returnType), new \PHPStan\Type\NullType()]);
    }
    private function resolveArgumentValue(\PhpParser\Node\Expr $expr) : ?string
    {
        if ($expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            if ((string) $expr->name !== 'class') {
                return null;
            }
            if ($expr->class instanceof \PhpParser\Node\Name) {
                return $expr->class->toString();
            }
            // some variable
            return null;
        }
        return null;
    }
}
