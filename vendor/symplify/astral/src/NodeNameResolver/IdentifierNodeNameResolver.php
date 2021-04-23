<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        if ($node instanceof \PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     * @return string|null
     */
    public function resolve($node)
    {
        return (string) $node;
    }
}
