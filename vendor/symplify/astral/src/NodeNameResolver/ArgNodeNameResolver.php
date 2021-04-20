<?php

declare (strict_types=1);
namespace RectorPrefix20210420\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Arg;
use RectorPrefix20210420\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \RectorPrefix20210420\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     * @return string|null
     */
    public function resolve(\PhpParser\Node $node)
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
