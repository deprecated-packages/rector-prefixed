<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;

final class NameNameResolver implements NodeNameResolverInterface
{
    /**
     * @var FuncCallNameResolver
     */
    private $funcCallNameResolver;

    public function __construct(FuncCallNameResolver $funcCallNameResolver)
    {
        $this->funcCallNameResolver = $funcCallNameResolver;
    }

    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return Name::class;
    }

    /**
     * @param Name $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        // possible function parent
        $parent = $node->getAttribute(AttributeKey::PARENT_NODE);
        if ($parent instanceof FuncCall) {
            return $this->funcCallNameResolver->resolve($parent);
        }

        $resolvedName = $node->getAttribute(AttributeKey::RESOLVED_NAME);
        if ($resolvedName instanceof FullyQualified) {
            return $resolvedName->toString();
        }

        return $node->toString();
    }
}
