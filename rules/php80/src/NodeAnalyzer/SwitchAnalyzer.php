<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_;
final class SwitchAnalyzer
{
    public function hasEachCaseBreak(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if (!$caseStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_) {
                    continue;
                }
                return \true;
            }
        }
        return \false;
    }
    public function hasEachCaseSingleStmt(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            $stmtsWithoutBreak = \array_filter($case->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool {
                return !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Break_;
            });
            if (\count($stmtsWithoutBreak) !== 1) {
                return \false;
            }
        }
        return \true;
    }
}
