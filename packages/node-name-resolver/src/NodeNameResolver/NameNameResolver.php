<?php

declare (strict_types=1);
namespace Rector\NodeNameResolver\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class NameNameResolver implements \Rector\NodeNameResolver\Contract\NodeNameResolverInterface
{
    public function getNode() : string
    {
        return \PhpParser\Node\Name::class;
    }
    /**
     * @param Name $node
     */
    public function resolve(\PhpParser\Node $node) : ?string
    {
        $resolvedName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME);
        if ($resolvedName instanceof \PhpParser\Node\Name\FullyQualified) {
            return $resolvedName->toString();
        }
        return $node->toString();
    }
}
