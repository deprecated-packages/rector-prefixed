<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class ClassLikeAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return string[]
     */
    public function resolvePropertyNames(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyNames = [];
        foreach ($classLike->getProperties() as $property) {
            $propertyNames[] = $this->nodeNameResolver->getName($property);
        }
        return $propertyNames;
    }
}
