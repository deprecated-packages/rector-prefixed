<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $statement, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
