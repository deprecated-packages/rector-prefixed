<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\Astral\Contract;

use PhpParser\Node;
interface NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool;
    /**
     * @return string|null
     * @param \PhpParser\Node $node
     */
    public function resolve($node);
}
