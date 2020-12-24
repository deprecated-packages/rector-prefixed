<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult;
interface ReturnStatementsNode extends \_PhpScoper0a6b37af0871\PHPStan\Node\VirtualNode
{
    /**
     * @return \PHPStan\Node\ReturnStatement[]
     */
    public function getReturnStatements() : array;
    public function getStatementResult() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\StatementResult;
    public function returnsByRef() : bool;
}
