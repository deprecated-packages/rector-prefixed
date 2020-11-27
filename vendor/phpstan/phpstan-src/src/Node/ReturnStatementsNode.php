<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
