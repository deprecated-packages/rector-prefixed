<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\NodeNameResolver;

final class UseNameResolver implements NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @required
     * @return void
     */
    public function autowireUseNameResolver(NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return Use_::class;
    }

    /**
     * @param Use_ $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        if ($node->uses === []) {
            return null;
        }

        $onlyUse = $node->uses[0];

        return $this->nodeNameResolver->getName($onlyUse);
    }
}
