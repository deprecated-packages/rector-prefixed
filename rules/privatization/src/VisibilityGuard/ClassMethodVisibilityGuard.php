<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Privatization\VisibilityGuard;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class ClassMethodVisibilityGuard
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isClassMethodVisibilityGuardedByParent(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->extends === null) {
            return \false;
        }
        $parentClasses = $this->getParentClasses($class);
        $propertyName = $this->nodeNameResolver->getName($classMethod);
        foreach ($parentClasses as $parentClass) {
            if (\method_exists($parentClass, $propertyName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return class-string[]
     */
    private function getParentClasses(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : array
    {
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($class);
        /** @var class-string[] $parents */
        $parents = (array) \class_parents($className);
        return $parents;
    }
}
