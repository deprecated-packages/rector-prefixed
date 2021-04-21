<?php

declare(strict_types=1);

namespace Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Arg;
use Symplify\Astral\Contract\NodeNameResolverInterface;

final class ArgNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node): bool
    {
        return $node instanceof Arg;
    }

    /**
     * @param Arg $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        if ($node->name === null) {
            return null;
        }

        return (string) $node->name;
    }
}
