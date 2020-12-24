<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\VendorLocker;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver;
final class VendorLockResolver
{
    /**
     * @var ClassMethodReturnVendorLockResolver
     */
    private $classMethodReturnVendorLockResolver;
    /**
     * @var ClassMethodParamVendorLockResolver
     */
    private $classMethodParamVendorLockResolver;
    /**
     * @var PropertyTypeVendorLockResolver
     */
    private $propertyTypeVendorLockResolver;
    /**
     * @var ClassMethodVendorLockResolver
     */
    private $classMethodVendorLockResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver $classMethodParamVendorLockResolver, \_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver $classMethodReturnVendorLockResolver, \_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver, \_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver $propertyTypeVendorLockResolver)
    {
        $this->classMethodReturnVendorLockResolver = $classMethodReturnVendorLockResolver;
        $this->classMethodParamVendorLockResolver = $classMethodParamVendorLockResolver;
        $this->propertyTypeVendorLockResolver = $propertyTypeVendorLockResolver;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function isClassMethodParamLockedIn(\_PhpScopere8e811afab72\PhpParser\Node $node, int $paramPosition) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        return $this->classMethodParamVendorLockResolver->isVendorLocked($node, $paramPosition);
    }
    public function isReturnChangeVendorLockedIn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodReturnVendorLockResolver->isVendorLocked($classMethod);
    }
    public function isPropertyTypeChangeVendorLockedIn(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->propertyTypeVendorLockResolver->isVendorLocked($property);
    }
    public function isClassMethodRemovalVendorLocked(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod);
    }
}
