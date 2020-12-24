<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class NameNameResolver implements \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?string
    {
        $resolvedName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified) {
            return $resolvedName->toString();
        }
        return $node->toString();
    }
}
