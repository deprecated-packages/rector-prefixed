<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyVisibilityVendorLockResolver extends \_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\AbstractNodeVendorLockResolver
{
    /**
     * Checks for:
     * - child classes required properties
     *
     * Prevents:
     * - changing visibility conflicting with children
     */
    public function isParentLockedProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        /** @var string $className */
        $className = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        return $this->hasParentProperty($className, $propertyName);
    }
    public function isChildLockedProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        /** @var string $className */
        $className = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        return $this->hasChildProperty($className, $propertyName);
    }
    private function hasParentProperty(string $className, string $propertyName) : bool
    {
        /** @var string[] $parentClasses */
        $parentClasses = (array) \class_parents($className);
        foreach ($parentClasses as $parentClass) {
            if (!\property_exists($parentClass, $propertyName)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    private function hasChildProperty(string $desiredClassName, string $propertyName) : bool
    {
        foreach (\get_declared_classes() as $className) {
            if ($className === $desiredClassName) {
                continue;
            }
            if (!\is_a($className, $desiredClassName, \true)) {
                continue;
            }
            if (\property_exists($className, $propertyName)) {
                return \true;
            }
        }
        return \false;
    }
}
