<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class ClassConstFetchNameResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireClassConstFetchNameResolver(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    /**
     * @param ClassConstFetch $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        $class = $this->nodeNameResolver->getName($node->class);
        $name = $this->nodeNameResolver->getName($node->name);
        if ($class === null || $name === null) {
            return null;
        }
        return $class . '::' . $name;
    }
}
