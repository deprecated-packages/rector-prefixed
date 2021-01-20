<?php

declare (strict_types=1);
namespace Rector\Defluent\ConflictGuard;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ParentClassMethodTypeOverrideGuard
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isReturnTypeChangeAllowed(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // make sure return type is not protected by parent contract
        $parentClassMethodReflection = $this->getParentClassMethod($classMethod);
        // nothign to check
        if (!$parentClassMethodReflection instanceof \PHPStan\Reflection\MethodReflection) {
            return \true;
        }
        $parentClassMethod = $this->nodeRepository->findClassMethodByMethodReflection($parentClassMethodReflection);
        // if null, we're unable to override → skip it
        return $parentClassMethod !== null;
    }
    private function getParentClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PHPStan\Reflection\MethodReflection
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $parentClassName = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($parentClassName)) {
            return null;
        }
        $parentClassReflection = $this->reflectionProvider->getClass($parentClassName);
        /** @var ClassReflection[] $parentClassesReflections */
        $parentClassesReflections = \array_merge([$parentClassReflection], $parentClassReflection->getParents());
        foreach ($parentClassesReflections as $parentClassesReflection) {
            if (!$parentClassesReflection->hasMethod($methodName)) {
                continue;
            }
            return $parentClassReflection->getNativeMethod($methodName);
        }
        return null;
    }
}
