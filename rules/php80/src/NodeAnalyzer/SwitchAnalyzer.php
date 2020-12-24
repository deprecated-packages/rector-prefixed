<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_;
final class SwitchAnalyzer
{
    public function hasEachCaseBreak(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if (!$caseStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_) {
                    continue;
                }
                return \true;
            }
        }
        return \false;
    }
    public function hasEachCaseSingleStmt(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            $stmtsWithoutBreak = \array_filter($case->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
                return !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_;
            });
            if (\count($stmtsWithoutBreak) !== 1) {
                return \false;
            }
        }
        return \true;
    }
}
