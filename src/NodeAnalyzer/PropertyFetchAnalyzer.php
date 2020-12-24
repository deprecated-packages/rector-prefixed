<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class PropertyFetchAnalyzer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isLocalPropertyFetch(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return $this->nodeNameResolver->isName($node->var, 'this');
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
            return $this->nodeNameResolver->isName($node->class, 'self');
        }
        return \false;
    }
    public function isLocalPropertyFetchName(\_PhpScopere8e811afab72\PhpParser\Node $node, string $desiredPropertyName) : bool
    {
        if (!$this->isLocalPropertyFetch($node)) {
            return \false;
        }
        /** @var PropertyFetch|StaticPropertyFetch $node */
        return $this->nodeNameResolver->isName($node->name, $desiredPropertyName);
    }
}
