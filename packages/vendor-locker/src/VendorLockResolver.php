<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver $classMethodParamVendorLockResolver, \_PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver $classMethodReturnVendorLockResolver, \_PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver, \_PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver $propertyTypeVendorLockResolver)
    {
        $this->classMethodReturnVendorLockResolver = $classMethodReturnVendorLockResolver;
        $this->classMethodParamVendorLockResolver = $classMethodParamVendorLockResolver;
        $this->propertyTypeVendorLockResolver = $propertyTypeVendorLockResolver;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function isClassMethodParamLockedIn(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, int $paramPosition) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        return $this->classMethodParamVendorLockResolver->isVendorLocked($node, $paramPosition);
    }
    public function isReturnChangeVendorLockedIn(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodReturnVendorLockResolver->isVendorLocked($classMethod);
    }
    public function isPropertyTypeChangeVendorLockedIn(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->propertyTypeVendorLockResolver->isVendorLocked($property);
    }
    public function isClassMethodRemovalVendorLocked(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod);
    }
}
