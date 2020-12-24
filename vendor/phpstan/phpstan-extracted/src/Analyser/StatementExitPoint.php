<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Analyser;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt $statement, \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
