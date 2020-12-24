<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\VendorLocker;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver;
use _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver;
use _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodParamVendorLockResolver $classMethodParamVendorLockResolver, \_PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver $classMethodReturnVendorLockResolver, \_PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver, \_PhpScoperb75b35f52b74\Rector\VendorLocker\NodeVendorLocker\PropertyTypeVendorLockResolver $propertyTypeVendorLockResolver)
    {
        $this->classMethodReturnVendorLockResolver = $classMethodReturnVendorLockResolver;
        $this->classMethodParamVendorLockResolver = $classMethodParamVendorLockResolver;
        $this->propertyTypeVendorLockResolver = $propertyTypeVendorLockResolver;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function isClassMethodParamLockedIn(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $paramPosition) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        return $this->classMethodParamVendorLockResolver->isVendorLocked($node, $paramPosition);
    }
    public function isReturnChangeVendorLockedIn(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodReturnVendorLockResolver->isVendorLocked($classMethod);
    }
    public function isPropertyTypeChangeVendorLockedIn(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->propertyTypeVendorLockResolver->isVendorLocked($property);
    }
    public function isClassMethodRemovalVendorLocked(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod);
    }
}
