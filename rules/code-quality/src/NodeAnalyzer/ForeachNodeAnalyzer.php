<?php

declare (strict_types=1);
namespace Rector\CodeQuality\NodeAnalyzer;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use Rector\Core\PhpParser\Comparing\NodeComparator;
final class ForeachNodeAnalyzer
{
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    public function __construct(\Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->nodeComparator = $nodeComparator;
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
}
