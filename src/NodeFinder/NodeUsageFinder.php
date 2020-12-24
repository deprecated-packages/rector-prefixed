<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\NodeFinder;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScopere8e811afab72\Rector\NodeNestingScope\NodeFinder\ScopeAwareNodeFinder $scopeAwareNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
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
    public function findVariableUsages(array $nodes, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : array
    {
        $variableName = $this->nodeNameResolver->getName($variable);
        return $this->betterNodeFinder->find($nodes, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($variable, $variableName) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
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
    public function findPropertyFetchUsages(\_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch $desiredPropertyFetch) : array
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
    public function findPreviousForeachNodeUsage(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->scopeAwareNodeFinder->findParent($foreach, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($expr) : bool {
            // skip itself
            if ($node === $expr) {
                return \false;
            }
            return $this->betterStandardPrinter->areNodesEqual($node, $expr);
        }, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class]);
    }
}
