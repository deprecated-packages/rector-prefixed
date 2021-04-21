<?php

declare(strict_types=1);

namespace Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Symplify\Astral\Contract\NodeNameResolverInterface;

final class PropertyNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node): bool
    {
        return $node instanceof Property;
    }

    /**
     * @param Property $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
