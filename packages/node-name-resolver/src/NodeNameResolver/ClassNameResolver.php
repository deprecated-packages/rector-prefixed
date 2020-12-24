<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class ClassNameResolver implements \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireClassNameResolver(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike::class;
    }
    /**
     * @param Class_ $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?string
    {
        if (\property_exists($node, 'namespacedName')) {
            return $node->namespacedName->toString();
        }
        if ($node->name === null) {
            return null;
        }
        return $this->nodeNameResolver->getName($node->name);
    }
}
