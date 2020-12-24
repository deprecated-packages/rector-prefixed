<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class PropertyFetchAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isLocalPropertyFetch(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return $this->nodeNameResolver->isName($node->var, 'this');
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
            return $this->nodeNameResolver->isName($node->class, 'self');
        }
        return \false;
    }
    public function isLocalPropertyFetchName(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $desiredPropertyName) : bool
    {
        if (!$this->isLocalPropertyFetch($node)) {
            return \false;
        }
        /** @var PropertyFetch|StaticPropertyFetch $node */
        return $this->nodeNameResolver->isName($node->name, $desiredPropertyName);
    }
}
