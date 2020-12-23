<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
