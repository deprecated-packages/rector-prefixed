<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\ConflictGuard;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
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
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isReturnTypeChangeAllowed(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // make sure return type is not protected by parent contract
        $parentClassMethodReflection = $this->getParentClassMethod($classMethod);
        // nothign to check
        if ($parentClassMethodReflection === null) {
            return \true;
        }
        $parentClassMethod = $this->nodeRepository->findClassMethodByMethodReflection($parentClassMethodReflection);
        // if null, we're unable to override → skip it
        return $parentClassMethod !== null;
    }
    private function getParentClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $parentClassName = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
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
