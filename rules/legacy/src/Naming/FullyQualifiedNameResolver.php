<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\Naming;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class FullyQualifiedNameResolver
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Node[] $nodes
     */
    public function resolveFullyQualifiedName(array $nodes, string $shortClassName) : string
    {
        /** @var Namespace_|null $namespace */
        $namespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class);
        if ($namespace === null) {
            return $shortClassName;
        }
        $namespaceName = $this->nodeNameResolver->getName($namespace);
        if ($namespaceName === null) {
            return $shortClassName;
        }
        return $namespaceName . '\\' . $shortClassName;
    }
}
