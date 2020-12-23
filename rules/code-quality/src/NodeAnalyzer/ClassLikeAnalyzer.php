<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\NodeAnalyzer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class ClassLikeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function resolvePropertyNames(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyNames = [];
        foreach ($classLike->getProperties() as $property) {
            $propertyNames[] = $this->nodeNameResolver->getName($property);
        }
        return $propertyNames;
    }
}
