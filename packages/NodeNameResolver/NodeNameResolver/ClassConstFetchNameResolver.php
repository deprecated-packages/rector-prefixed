<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\NodeNameResolver;

final class ClassConstFetchNameResolver implements NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @required
     * @return void
     */
    public function autowireClassConstFetchNameResolver(NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return ClassConstFetch::class;
    }

    /**
     * @param ClassConstFetch $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        $class = $this->nodeNameResolver->getName($node->class);
        $name = $this->nodeNameResolver->getName($node->name);
        if ($class === null) {
            return null;
        }
        if ($name === null) {
            return null;
        }

        return $class . '::' . $name;
    }
}
