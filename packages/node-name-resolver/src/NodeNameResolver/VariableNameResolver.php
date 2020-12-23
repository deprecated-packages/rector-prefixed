<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableNameResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable::class;
    }
    /**
     * @param Variable $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // skip $some->$dynamicMethodName()
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall && $node === $parentNode->name) {
            return null;
        }
        // skip $some->$dynamicPropertyName
        if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch && $node === $parentNode->name) {
            return null;
        }
        if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
