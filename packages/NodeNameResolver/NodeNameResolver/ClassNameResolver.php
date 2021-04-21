<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\NodeNameResolver;

final class ClassNameResolver implements NodeNameResolverInterface
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @required
     * @return void
     */
    public function autowireClassNameResolver(NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return ClassLike::class;
    }

    /**
     * @param Class_ $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        if (property_exists($node, 'namespacedName')) {
            return $node->namespacedName->toString();
        }

        if ($node->name === null) {
            return null;
        }

        return $this->nodeNameResolver->getName($node->name);
    }
}
