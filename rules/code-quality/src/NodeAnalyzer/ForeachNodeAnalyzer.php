<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class ForeachNodeAnalyzer
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * Matches$
     * foreach ($values as $value) {
     *      <$assigns[]> = $value;
     * }
     */
    public function matchAssignItemsOnlyForeachArrayVariable(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if (\count((array) $foreach->stmts) !== 1) {
            return null;
        }
        $onlyStatement = $foreach->stmts[0];
        if ($onlyStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            $onlyStatement = $onlyStatement->expr;
        }
        if (!$onlyStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyStatement->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if ($onlyStatement->var->dim !== null) {
            return null;
        }
        if (!$this->betterStandardPrinter->areNodesEqual($foreach->valueVar, $onlyStatement->expr)) {
            return null;
        }
        return $onlyStatement->var->var;
    }
}
