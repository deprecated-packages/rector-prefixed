<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\PostRector\Collector\NodesToRemoveCollector;
final class ClassManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @deprecated
     * @param Class_|Trait_ $classLike
     * @return array<string, Name>
     */
    public function getUsedTraits(\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $usedTraits = [];
        foreach ($classLike->getTraitUses() as $traitUse) {
            foreach ($traitUse->traits as $trait) {
                /** @var string $traitName */
                $traitName = $this->nodeNameResolver->getName($trait);
                $usedTraits[$traitName] = $trait;
            }
        }
        return $usedTraits;
    }
    public function hasParentMethodOrInterface(\PHPStan\Type\ObjectType $objectType, string $methodName) : bool
    {
        if (!$this->reflectionProvider->hasClass($objectType->getClassName())) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($objectType->getClassName());
        /** @var ClassReflection[] $parentClassReflections */
        $parentClassReflections = \array_merge($classReflection->getParents(), $classReflection->getInterfaces());
        foreach ($parentClassReflections as $parentClassReflection) {
            if ($parentClassReflection->hasMethod($methodName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return string[]
     */
    public function getPrivatePropertyNames(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $privateProperties = \array_filter($class->getProperties(), function (\PhpParser\Node\Stmt\Property $property) : bool {
            return $property->isPrivate();
        });
        return $this->nodeNameResolver->getNames($privateProperties);
    }
    /**
     * @return string[]
     */
    public function getPublicMethodNames(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $publicMethodNames = [];
        foreach ($class->getMethods() as $classMethod) {
            if ($classMethod->isAbstract()) {
                continue;
            }
            if ($classMethod->isAbstract()) {
                continue;
            }
            $publicMethodNames[] = $this->nodeNameResolver->getName($classMethod);
        }
        return $publicMethodNames;
    }
    /**
     * @return string[]
     */
    public function getImplementedInterfaceNames(\PhpParser\Node\Stmt\Class_ $class) : array
    {
        return $this->nodeNameResolver->getNames($class->implements);
    }
    public function hasInterface(\PhpParser\Node\Stmt\Class_ $class, \PHPStan\Type\ObjectType $interfaceObjectType) : bool
    {
        return $this->nodeNameResolver->isName($class->implements, $interfaceObjectType->getClassName());
    }
    public function hasTrait(\PhpParser\Node\Stmt\Class_ $class, string $desiredTrait) : bool
    {
        foreach ($class->getTraitUses() as $traitUse) {
            if (!$this->nodeNameResolver->isName($traitUse->traits, $desiredTrait)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function replaceTrait(\PhpParser\Node\Stmt\Class_ $class, string $oldTrait, string $newTrait) : void
    {
        foreach ($class->getTraitUses() as $traitUse) {
            foreach ($traitUse->traits as $key => $traitTrait) {
                if (!$this->nodeNameResolver->isName($traitTrait, $oldTrait)) {
                    continue;
                }
                $traitUse->traits[$key] = new \PhpParser\Node\Name\FullyQualified($newTrait);
                break;
            }
        }
    }
    /**
     * @param Class_|Interface_ $classLike
     * @return string[]
     */
    public function getClassLikeNodeParentInterfaceNames(\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        if ($classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->nodeNameResolver->getNames($classLike->implements);
        }
        return $this->nodeNameResolver->getNames($classLike->extends);
    }
    public function removeInterface(\PhpParser\Node\Stmt\Class_ $class, string $desiredInterface) : void
    {
        foreach ($class->implements as $implement) {
            if (!$this->nodeNameResolver->isName($implement, $desiredInterface)) {
                continue;
            }
            $this->nodesToRemoveCollector->addNodeToRemove($implement);
        }
    }
}
