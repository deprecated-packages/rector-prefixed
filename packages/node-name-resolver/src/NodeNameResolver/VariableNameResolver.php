<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class VariableNameResolver implements \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable::class;
    }
    /**
     * @param Variable $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // skip $some->$dynamicMethodName()
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall && $node === $parentNode->name) {
            return null;
        }
        // skip $some->$dynamicPropertyName
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && $node === $parentNode->name) {
            return null;
        }
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
