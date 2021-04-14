<?php

declare(strict_types=1);

namespace Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use Symplify\Astral\Contract\NodeNameResolverInterface;

final class AttributeNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node): bool
    {
        return $node instanceof Attribute;
    }

    /**
     * @param Attribute $node
     */
    public function resolve(Node $node): ?string
    {
        return $node->name->toString();
    }
}
