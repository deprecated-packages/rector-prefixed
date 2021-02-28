<?php

declare (strict_types=1);
namespace Rector\VendorLocker\NodeVendorLocker;

use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariantWithPhpDocs;
use PHPStan\Type\MixedType;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ClassMethodReturnVendorLockResolver extends \Rector\VendorLocker\NodeVendorLocker\AbstractNodeVendorLockResolver
{
    public function isVendorLocked(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $scope = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return \false;
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof \PHPStan\Reflection\ClassReflection) {
            return \false;
        }
        if (!$this->hasParentClassChildrenClassesOrImplementsInterface($classReflection)) {
            return \false;
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        if ($this->isVendorLockedByParentClass($classReflection, $methodName)) {
            return \true;
        }
        if ($classReflection->isTrait()) {
            return \false;
        }
        return $this->isMethodVendorLockedByInterface($classReflection, $methodName);
    }
    private function isVendorLockedByParentClass(\PHPStan\Reflection\ClassReflection $classReflection, string $methodName) : bool
    {
        foreach ($classReflection->getParents() as $parentClassReflections) {
            if (!$parentClassReflections->hasMethod($methodName)) {
                continue;
            }
            $parentClassMethodReflection = $parentClassReflections->getNativeMethod($methodName);
            $parametersAcceptor = $parentClassMethodReflection->getVariants()[0];
            if (!$parametersAcceptor instanceof \PHPStan\Reflection\FunctionVariantWithPhpDocs) {
                continue;
            }
            // here we count only on strict types, not on docs
            return !$parametersAcceptor->getNativeReturnType() instanceof \PHPStan\Type\MixedType;
        }
        return \false;
    }
}
