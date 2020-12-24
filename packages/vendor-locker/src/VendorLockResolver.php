<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\VendorLocker;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver;
use _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver;
use _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver $classMethodParamVendorLockResolver, \_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver $classMethodReturnVendorLockResolver, \_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver, \_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver $propertyTypeVendorLockResolver)
    {
        $this->classMethodReturnVendorLockResolver = $classMethodReturnVendorLockResolver;
        $this->classMethodParamVendorLockResolver = $classMethodParamVendorLockResolver;
        $this->propertyTypeVendorLockResolver = $propertyTypeVendorLockResolver;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function isClassMethodParamLockedIn(\_PhpScoper0a6b37af0871\PhpParser\Node $node, int $paramPosition) : bool
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        return $this->classMethodParamVendorLockResolver->isVendorLocked($node, $paramPosition);
    }
    public function isReturnChangeVendorLockedIn(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodReturnVendorLockResolver->isVendorLocked($classMethod);
    }
    public function isPropertyTypeChangeVendorLockedIn(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->propertyTypeVendorLockResolver->isVendorLocked($property);
    }
    public function isClassMethodRemovalVendorLocked(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod);
    }
}
