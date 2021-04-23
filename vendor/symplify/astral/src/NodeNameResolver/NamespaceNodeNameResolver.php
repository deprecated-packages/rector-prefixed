<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface;
final class NamespaceNodeNameResolver implements \RectorPrefix20210423\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Stmt\Namespace_;
    }
    /**
     * @param Namespace_ $node
     * @return string|null
     */
    public function resolve(\PhpParser\Node $node)
    {
        if ($node->name === null) {
            return null;
        }
        return $node->name->toString();
    }
}
