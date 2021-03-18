<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\ClassMethod;
//use PHPStan\Analyser\Scope;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassMethodReturnTypeOverrideGuard
{
    /**
     * @var array<class-string, array<string>>
     */
    private const CHAOTIC_CLASS_METHOD_NAMES = ['PhpParser\\NodeVisitor' => ['enterNode', 'leaveNode', 'beforeTraverse', 'afterTraverse']];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var FamilyRelationsAnalyzer
     */
    private $familyRelationsAnalyzer;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\FamilyTree\Reflection\FamilyRelationsAnalyzer $familyRelationsAnalyzer, \Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->reflectionProvider = $reflectionProvider;
        $this->familyRelationsAnalyzer = $familyRelationsAnalyzer;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function shouldSkipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // 1. skip magic methods
        if ($classMethod->isMagic()) {
            return \true;
        }
        // 2. skip chaotic contract class methods
        if ($this->shouldSkipChaoticClassMethods($classMethod)) {
            return \true;
        }
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return \false;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $childrenClassReflections = $this->familyRelationsAnalyzer->getChildrenOfClassReflection($classReflection);
        if ($childrenClassReflections === []) {
            return \false;
        }
        if ($this->hasClassMethodExprReturn($classMethod)) {
            return \false;
        }
        return $classMethod->returnType === null;
    }
    public function shouldSkipClassMethodOldTypeWithNewType(\PHPStan\Type\Type $oldType, \PHPStan\Type\Type $newType) : bool
    {
        if ($oldType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        // new generic string type is more advanced than old array type
        if ($oldType instanceof \PHPStan\Type\ArrayType && $newType instanceof \PHPStan\Type\ArrayType && ($oldType->getItemType() instanceof \PHPStan\Type\StringType && $newType->getItemType() instanceof \PHPStan\Type\Generic\GenericClassStringType)) {
            return \false;
        }
        if ($oldType->isSuperTypeOf($newType)->yes()) {
            return \true;
        }
        return $this->isArrayMutualType($newType, $oldType);
    }
    private function shouldSkipChaoticClassMethods(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string|null $className */
        $className = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return \false;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        foreach (self::CHAOTIC_CLASS_METHOD_NAMES as $chaoticClass => $chaoticMethodNames) {
            if (!$this->reflectionProvider->hasClass($chaoticClass)) {
                continue;
            }
            $chaoticClassReflection = $this->reflectionProvider->getClass($chaoticClass);
            if (!$classReflection->isSubclassOf($chaoticClassReflection->getName())) {
                continue;
            }
            return $this->nodeNameResolver->isNames($classMethod, $chaoticMethodNames);
        }
        return \false;
    }
    private function isArrayMutualType(\PHPStan\Type\Type $newType, \PHPStan\Type\Type $oldType) : bool
    {
        if (!$newType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$oldType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        $oldTypeWithClassName = $oldType->getItemType();
        if (!$oldTypeWithClassName instanceof \PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $arrayItemType = $newType->getItemType();
        if (!$arrayItemType instanceof \PHPStan\Type\UnionType) {
            return \false;
        }
        $isMatchingClassTypes = \false;
        foreach ($arrayItemType->getTypes() as $newUnionedType) {
            if (!$newUnionedType instanceof \PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $oldClass = $this->nodeTypeResolver->getFullyQualifiedClassName($oldTypeWithClassName);
            $newClass = $this->nodeTypeResolver->getFullyQualifiedClassName($newUnionedType);
            if (\is_a($oldClass, $newClass, \true) || \is_a($newClass, $oldClass, \true)) {
                $isMatchingClassTypes = \true;
            } else {
                return \false;
            }
        }
        return $isMatchingClassTypes;
    }
    private function hasClassMethodExprReturn(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            return $node->expr instanceof \PhpParser\Node\Expr;
        });
    }
}
