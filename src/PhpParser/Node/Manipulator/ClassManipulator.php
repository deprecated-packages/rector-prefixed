<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector;
final class ClassManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
    }
    /**
     * @param Class_|Trait_ $classLike
     * @return Name[]
     */
    public function getUsedTraits(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : array
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
    public function hasParentMethodOrInterface(string $class, string $method) : bool
    {
        if (!\class_exists($class)) {
            return \false;
        }
        $parentClass = $class;
        while ($parentClass = \get_parent_class($parentClass)) {
            if (\method_exists($parentClass, $method)) {
                return \true;
            }
        }
        $implementedInterfaces = (array) \class_implements($class);
        foreach ($implementedInterfaces as $implementedInterface) {
            /** @var string $implementedInterface */
            if (\method_exists($implementedInterface, $method)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return string[]
     */
    public function getPrivatePropertyNames(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $privateProperties = \array_filter($class->getProperties(), function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : bool {
            return $property->isPrivate();
        });
        return $this->nodeNameResolver->getNames($privateProperties);
    }
    /**
     * @return string[]
     */
    public function getPublicMethodNames(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $publicMethods = \array_filter($class->getMethods(), function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool {
            if ($classMethod->isAbstract()) {
                return \false;
            }
            return $classMethod->isPublic();
        });
        return $this->nodeNameResolver->getNames($publicMethods);
    }
    public function findPropertyByType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $serviceType) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->nodeTypeResolver->isObjectType($property, $serviceType)) {
                continue;
            }
            return $property;
        }
        return null;
    }
    /**
     * @return string[]
     */
    public function getImplementedInterfaceNames(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : array
    {
        return $this->nodeNameResolver->getNames($class->implements);
    }
    public function hasInterface(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $desiredInterface) : bool
    {
        return $this->nodeNameResolver->haveName($class->implements, $desiredInterface);
    }
    public function hasTrait(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $desiredTrait) : bool
    {
        foreach ($class->getTraitUses() as $traitUse) {
            if (!$this->nodeNameResolver->haveName($traitUse->traits, $desiredTrait)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function replaceTrait(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $oldTrait, string $newTrait) : void
    {
        foreach ($class->getTraitUses() as $traitUse) {
            foreach ($traitUse->traits as $key => $traitTrait) {
                if (!$this->nodeNameResolver->isName($traitTrait, $oldTrait)) {
                    continue;
                }
                $traitUse->traits[$key] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($newTrait);
                break;
            }
        }
    }
    /**
     * @param Class_|Interface_ $classLike
     * @return string[]
     */
    public function getClassLikeNodeParentInterfaceNames(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        if ($classLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return $this->nodeNameResolver->getNames($classLike->implements);
        }
        return $this->nodeNameResolver->getNames($classLike->extends);
    }
    public function removeInterface(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class, string $desiredInterface) : void
    {
        foreach ($class->implements as $implement) {
            if (!$this->nodeNameResolver->isName($implement, $desiredInterface)) {
                continue;
            }
            $this->nodesToRemoveCollector->addNodeToRemove($implement);
        }
    }
}
