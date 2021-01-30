<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitor;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ClassMethodReturnTypeOverrideGuard
{
    /**
     * @var array<string, array<string>>
     */
    private const CHAOTIC_CLASS_METHOD_NAMES = [\PhpParser\NodeVisitor::class => ['enterNode', 'leaveNode', 'beforeTraverse', 'afterTraverse']];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function shouldSkipClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // 1. skip magic methods
        if ($this->nodeNameResolver->isName($classMethod->name, '__*')) {
            return \true;
        }
        // 2. skip chaotic contract class methods
        return $this->shouldSkipChaoticClassMethods($classMethod);
    }
    public function shouldSkipClassMethodOldTypeWithNewType(\PHPStan\Type\Type $oldType, \PHPStan\Type\Type $newType) : bool
    {
        if ($oldType instanceof \PHPStan\Type\MixedType) {
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
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        foreach (self::CHAOTIC_CLASS_METHOD_NAMES as $chaoticClass => $chaoticMethodNames) {
            if (!\is_a($className, $chaoticClass, \true)) {
                continue;
            }
            return \in_array($methodName, $chaoticMethodNames, \true);
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
}
