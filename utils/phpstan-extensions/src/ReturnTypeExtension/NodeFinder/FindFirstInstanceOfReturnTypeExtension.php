<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\ReturnTypeExtension\NodeFinder;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
final class FindFirstInstanceOfReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Rector\Core\PhpParser\Node\BetterNodeFinder::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return \in_array($methodReflection->getName(), ['findFirstInstanceOf', 'findFirstParentInstanceOf', 'findFirstAncestorInstanceOf'], \true);
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        $secondArgumentNode = $methodCall->args[1]->value;
        // fallback
        if ($this->shouldFallbackToResolvedType($secondArgumentNode)) {
            return $returnType;
        }
        /** @var ClassConstFetch $secondArgumentNode */
        $class = $secondArgumentNode->class->toString();
        return new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\ObjectType($class)]);
    }
    private function shouldFallbackToResolvedType(\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return \true;
        }
        if (!$expr->class instanceof \PhpParser\Node\Name) {
            return \true;
        }
        return (string) $expr->name !== 'class';
    }
}
