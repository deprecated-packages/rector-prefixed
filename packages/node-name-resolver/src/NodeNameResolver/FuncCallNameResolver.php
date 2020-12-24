<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class FuncCallNameResolver implements \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class;
    }
    /**
     * If some function is namespaced, it will be used over global one.
     * But only if it really exists.
     *
     * @param FuncCall $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return null;
        }
        $functionName = $node->name;
        if (!$functionName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return (string) $functionName;
        }
        $namespaceName = $functionName->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACED_NAME);
        if ($namespaceName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
            $functionFqnName = $namespaceName->toString();
            if (\function_exists($functionFqnName)) {
                return $functionFqnName;
            }
        }
        return (string) $functionName;
    }
}
