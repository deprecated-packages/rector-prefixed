<?php

declare(strict_types=1);

namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;

final class VariableNameResolver implements NodeNameResolverInterface
{
    /**
     * @return class-string<Node>
     */
    public function getNode(): string
    {
        return Variable::class;
    }

    /**
     * @param Variable $node
     * @return string|null
     */
    public function resolve(Node $node)
    {
        $parentNode = $node->getAttribute(AttributeKey::PARENT_NODE);

        // skip $some->$dynamicMethodName()
        if ($parentNode instanceof MethodCall && $node === $parentNode->name) {
            return null;
        }

        // skip $some->$dynamicPropertyName
        if ($parentNode instanceof PropertyFetch && $node === $parentNode->name) {
            return null;
        }

        if ($node->name instanceof Expr) {
            return null;
        }

        return $node->name;
    }
}
