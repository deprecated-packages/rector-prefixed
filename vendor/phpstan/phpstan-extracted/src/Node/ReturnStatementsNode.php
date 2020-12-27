<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Node;

use RectorPrefix20201227\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \RectorPrefix20201227\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \RectorPrefix20201227\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
