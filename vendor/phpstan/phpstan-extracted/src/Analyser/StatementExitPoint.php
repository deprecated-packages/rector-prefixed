<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Analyser;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt $statement, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
