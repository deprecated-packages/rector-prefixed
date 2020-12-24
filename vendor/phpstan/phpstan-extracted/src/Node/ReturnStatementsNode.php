<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
