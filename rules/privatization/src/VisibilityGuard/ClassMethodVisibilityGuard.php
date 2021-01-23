<?php

declare (strict_types=1);
namespace Rector\Privatization\VisibilityGuard;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassMethodVisibilityGuard
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isClassMethodVisibilityGuardedByParent(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $parentClasses = $this->getParentClasses($classLike);
        $classInterfaces = $this->getClassInterfaces($classLike);
        $classClassLikes = \array_merge($parentClasses, $classInterfaces);
        return $this->methodExistsInClasses($classClassLikes, $methodName);
    }
    public function isClassMethodVisibilityGuardedByTrait(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        $traits = $this->getParentTraits($classLike);
        $methodName = $this->nodeNameResolver->getName($classMethod);
        return $this->methodExistsInClasses($traits, $methodName);
    }
    /**
     * @return string[]
     */
    public function getParentTraits(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        $traits = \class_uses($className);
        if ($traits === \false) {
            return [];
        }
        return $traits;
    }
    /**
     * @return string[]
     */
    private function getParentClasses(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        $classParents = \class_parents($className);
        if ($classParents === \false) {
            return [];
        }
        return $classParents;
    }
    /**
     * @return string[]
     */
    private function getClassInterfaces(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        $classInterfaces = \class_implements($className);
        if ($classInterfaces === \false) {
            return [];
        }
        return $classInterfaces;
    }
    /**
     * @param string[] $classes
     */
    private function methodExistsInClasses(array $classes, string $method) : bool
    {
        foreach ($classes as $class) {
            if (\method_exists($class, $method)) {
                return \true;
            }
        }
        return \false;
    }
}
