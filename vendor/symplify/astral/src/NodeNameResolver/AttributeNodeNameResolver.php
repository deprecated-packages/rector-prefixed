<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use RectorPrefix20210421\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \RectorPrefix20210421\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     * @return string|null
     */
    public function resolve(\PhpParser\Node $node)
    {
        return $node->name->toString();
    }
}
