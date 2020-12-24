<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionProperty;
final class PropertyTypeVendorLockResolver extends \_PhpScoper0a6b37af0871\Rector\VendorLocker\NodeVendorLocker\AbstractNodeVendorLockResolver
{
    public function isVendorLocked(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        /** @var Class_|Interface_ $classLike */
        if (!$this->hasParentClassChildrenClassesOrImplementsInterface($classLike)) {
            return \false;
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        if ($this->isParentClassLocked($classLike, $propertyName)) {
            return \true;
        }
        return $this->isChildClassLocked($property, $classLike, $propertyName);
    }
    /**
     * @param Class_|Interface_ $classLike
     */
    private function isParentClassLocked(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        // extract to some "inherited parent method" service
        /** @var string|null $parentClassName */
        $parentClassName = $classLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName === null) {
            return \false;
        }
        // if not, look for it's parent parent - recursion
        if (\property_exists($parentClassName, $propertyName)) {
            // validate type is conflicting
            // parent class property in external scope → it's not ok
            return \true;
            // if not, look for it's parent parent
        }
        return \false;
    }
    /**
     * @param Class_|Interface_ $classLike
     */
    private function isChildClassLocked(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        // is child class locker
        if ($property->isPrivate()) {
            return \false;
        }
        $childrenClassNames = $this->getChildrenClassesByClass($classLike);
        foreach ($childrenClassNames as $childClassName) {
            if (!\property_exists($childClassName, $propertyName)) {
                continue;
            }
            // ensure the property is not in the parent class
            $reflectionProperty = new \ReflectionProperty($childClassName, $propertyName);
            if ($reflectionProperty->class !== $childClassName) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
