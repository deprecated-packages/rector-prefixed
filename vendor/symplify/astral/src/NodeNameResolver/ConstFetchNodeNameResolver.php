<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ConstFetchNodeNameResolver implements \RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\ConstFetch;
    }
    /**
     * @param \PhpParser\Node $node
     * @return string|null
     */
    public function resolve($node)
    {
        // convention to save uppercase and lowercase functions for each name
        return $node->name->toLowerString();
    }
}
