<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
final class UseNameResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     */
    public function autowireUseNameResolver(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver) : void
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function getNode() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::class;
    }
    /**
     * @param Use_ $node
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?string
    {
        if ($node->uses === []) {
            return null;
        }
        $onlyUse = $node->uses[0];
        return $this->nodeNameResolver->getName($onlyUse);
    }
}
