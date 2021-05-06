<?php

declare (strict_types=1);
namespace Rector\Transform\Naming;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNameResolver\NodeNameResolver;
final class FullyQualifiedNameResolver
{
    /**
     * @var \Rector\Core\PhpParser\Node\BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Node[] $nodes
     */
    public function resolveFullyQualifiedName(array $nodes, string $shortClassName) : string
    {
        $namespace = $this->betterNodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\Namespace_::class);
        if (!$namespace instanceof \PhpParser\Node\Stmt\Namespace_) {
            return $shortClassName;
        }
        $namespaceName = $this->nodeNameResolver->getName($namespace);
        if ($namespaceName === null) {
            return $shortClassName;
        }
        return $namespaceName . '\\' . $shortClassName;
    }
}
