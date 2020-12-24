<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
