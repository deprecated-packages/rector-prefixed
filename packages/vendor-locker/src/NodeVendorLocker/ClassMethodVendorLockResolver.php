<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\VendorLocker\NodeVendorLocker;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionClass;
final class ClassMethodVendorLockResolver extends \_PhpScoper0a2ac50786fa\Rector\VendorLocker\NodeVendorLocker\AbstractNodeVendorLockResolver
{
    /**
     * Checks for:
     * - interface required methods
     * - abstract classes reqired method
     *
     * Prevent:
     * - removing class methods, that breaks the code
     */
    public function isRemovalVendorLocked(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string $classMethodName */
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        /** @var Class_|Interface_|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        if ($this->isMethodVendorLockedByInterface($classLike, $classMethodName)) {
            return \true;
        }
        if ($classLike->extends === null) {
            return \false;
        }
        /** @var string $className */
        $className = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        /** @var string[] $classParents */
        $classParents = (array) \class_parents($className);
        foreach ($classParents as $classParent) {
            if (!\class_exists($classParent)) {
                continue;
            }
            $parentClassReflection = new \ReflectionClass($classParent);
            if (!$parentClassReflection->hasMethod($classMethodName)) {
                continue;
            }
            $methodReflection = $parentClassReflection->getMethod($classMethodName);
            if (!$methodReflection->isAbstract()) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
