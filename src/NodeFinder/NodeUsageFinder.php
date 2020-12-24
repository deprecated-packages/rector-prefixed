<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\NodeFinder;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder;
final class NodeUsageFinder
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ScopeAwareNodeFinder
     */
    private $scopeAwareNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder $scopeAwareNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeRepository = $nodeRepository;
        $this->scopeAwareNodeFinder = $scopeAwareNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Node[] $nodes
     * @return Variable[]
     */
    public function findVariableUsages(array $nodes, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : array
    {
        $variableName = $this->nodeNameResolver->getName($variable);
        return $this->betterNodeFinder->find($nodes, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($variable, $variableName) : bool {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                return \false;
            }
            if ($node === $variable) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node, $variableName);
        });
    }
    /**
     * @return PropertyFetch[]
     */
    public function findPropertyFetchUsages(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch $desiredPropertyFetch) : array
    {
        $propertyFetches = $this->nodeRepository->findPropertyFetchesByPropertyFetch($desiredPropertyFetch);
        $propertyFetchesWithoutPropertyFetch = [];
        foreach ($propertyFetches as $propertyFetch) {
            if ($propertyFetch === $desiredPropertyFetch) {
                continue;
            }
            $propertyFetchesWithoutPropertyFetch[] = $propertyFetch;
        }
        return $propertyFetchesWithoutPropertyFetch;
    }
    public function findPreviousForeachNodeUsage(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_ $foreach, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->scopeAwareNodeFinder->findParent($foreach, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use($expr) : bool {
            // skip itself
            if ($node === $expr) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $expr);
        }, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class]);
    }
}
