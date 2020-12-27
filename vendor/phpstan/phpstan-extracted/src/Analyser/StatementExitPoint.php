<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\PhpParser\Node\Stmt $statement, \RectorPrefix20201227\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \RectorPrefix20201227\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
