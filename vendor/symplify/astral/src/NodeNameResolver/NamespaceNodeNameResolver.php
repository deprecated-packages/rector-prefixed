<?php

declare(strict_types=1);

namespace Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use Symplify\Astral\Contract\NodeNameResolverInterface;

final class NamespaceNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node): bool
    {
        return $node instanceof Namespace_;
    }

    /**
     * @param Namespace_ $node
     */
    public function resolve(Node $node): ?string
    {
        if ($node->name === null) {
            return null;
        }

        return $node->name->toString();
    }
}
