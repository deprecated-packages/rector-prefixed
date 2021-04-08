<?php

declare (strict_types=1);
namespace Rector\CodeQuality\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ForeachAnalyzer
{
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    /**
     * @var ForAnalyzer
     */
    private $forAnalyzer;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator, \Rector\CodeQuality\NodeAnalyzer\ForAnalyzer $forAnalyzer, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->nodeComparator = $nodeComparator;
        $this->forAnalyzer = $forAnalyzer;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    /**
     * Matches$
     * foreach ($values as $value) {
     *      <$assigns[]> = $value;
     * }
     */
    public function matchAssignItemsOnlyForeachArrayVariable(\PhpParser\Node\Stmt\Foreach_ $foreach) : ?\PhpParser\Node\Expr
    {
        if (\count($foreach->stmts) !== 1) {
            return null;
        }
        $onlyStatement = $foreach->stmts[0];
        if ($onlyStatement instanceof \PhpParser\Node\Stmt\Expression) {
            $onlyStatement = $onlyStatement->expr;
        }
        if (!$onlyStatement instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyStatement->var instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if ($onlyStatement->var->dim !== null) {
            return null;
        }
        if (!$this->nodeComparator->areNodesEqual($foreach->valueVar, $onlyStatement->expr)) {
            return null;
        }
        return $onlyStatement->var->var;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function useForeachVariableInStmts(\PhpParser\Node\Expr $foreachedValue, \PhpParser\Node\Expr $singleValue, array $stmts, string $keyValueName) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use($foreachedValue, $singleValue, $keyValueName) : ?Expr {
            if (!$node instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
                return null;
            }
            // must be the same as foreach value
            if (!$this->nodeComparator->areNodesEqual($node->var, $foreachedValue)) {
                return null;
            }
            if ($this->forAnalyzer->isArrayDimFetchPartOfAssignOrArgParentCount($node)) {
                return null;
            }
            // is dim same as key value name, ...[$i]
            if (!$node->dim instanceof \PhpParser\Node\Expr\Variable) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node->dim, $keyValueName)) {
                return null;
            }
            return $singleValue;
        });
    }
}
