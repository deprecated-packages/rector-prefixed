<?php

declare (strict_types=1);
namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\NodeNameResolver;
final class PropertyNameResolver implements \Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @required
     * @return void
     */
    public function autowirePropertyNameResolver(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return class-string<Node>
     */
    public function getNode() : string
    {
        return \PhpParser\Node\Stmt\Property::class;
    }
    /**
     * @param \PhpParser\Node $node
     * @return string|null
     */
    public function resolve($node)
    {
        if ($node->props === []) {
            return null;
        }
        $onlyProperty = $node->props[0];
        return $this->nodeNameResolver->getName($onlyProperty);
    }
}
