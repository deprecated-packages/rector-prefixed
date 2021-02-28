<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Privatization\VisibilityGuard\ClassMethodVisibilityGuard;
/**
 * @deprecated
 * Merge with @see ClassMethodVisibilityGuard
 */
final class ClassMethodVisibilityVendorLockResolver extends \Rector\VendorLocker\NodeVendorLocker\AbstractNodeVendorLockResolver
{
    /**
     * Checks for:
     * - interface required methods
     * - abstract classes required method
     * - child classes required method
     *
     * Prevents:
     * - changing visibility conflicting with children
     */
    public function isParentLockedMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Scope $scope */
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        /** @var ClassReflection[] $parentClassReflections */
        $parentClassReflections = \array_merge($classReflection->getParents(), $classReflection->getInterfaces());
        foreach ($parentClassReflections as $parentClassReflection) {
            if ($parentClassReflection->hasMethod($methodName)) {
                return \true;
            }
        }
        return \false;
    }
    public function isChildLockedMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var Scope $scope */
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        $childrenClassReflections = $this->familyRelationsAnalyzer->getChildrenOfClassReflection($classReflection);
        foreach ($childrenClassReflections as $childClassReflection) {
            if ($childClassReflection->hasMethod($methodName)) {
                return \true;
            }
        }
        return \false;
    }
}
