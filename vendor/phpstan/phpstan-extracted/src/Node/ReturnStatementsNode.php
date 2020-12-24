<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \_PhpScopere8e811afab72\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
