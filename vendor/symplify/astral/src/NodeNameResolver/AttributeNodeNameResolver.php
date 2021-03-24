<?php

declare (strict_types=1);
namespace RectorPrefix20210324\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use RectorPrefix20210324\Symplify\Astral\Contract\NodeNameResolverInterface;
final class AttributeNodeNameResolver implements \RectorPrefix20210324\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Attribute;
    }
    /**
     * @param Attribute $node
     */
    public function resolve(\PhpParser\Node $node) : ?string
    {
        return $node->name->toString();
    }
}
