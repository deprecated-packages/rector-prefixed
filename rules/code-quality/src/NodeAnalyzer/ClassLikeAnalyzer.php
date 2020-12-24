<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class ClassLikeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function resolvePropertyNames(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyNames = [];
        foreach ($classLike->getProperties() as $property) {
            $propertyNames[] = $this->nodeNameResolver->getName($property);
        }
        return $propertyNames;
    }
}
