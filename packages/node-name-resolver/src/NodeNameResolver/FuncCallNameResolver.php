<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
final class FuncCallNameResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class;
    }
    /**
     * If some function is namespaced, it will be used over global one.
     * But only if it really exists.
     *
     * @param FuncCall $node
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return null;
        }
        $functionName = $node->name;
        if (!$functionName instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            return (string) $functionName;
        }
        $namespaceName = $functionName->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACED_NAME);
        if ($namespaceName instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified) {
            $functionFqnName = $namespaceName->toString();
            if (\function_exists($functionFqnName)) {
                return $functionFqnName;
            }
        }
        return (string) $functionName;
    }
}
