<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\Node\Stmt;
class StatementExitPoint
{
    /**
     * @var \PhpParser\Node\Stmt
     */
    private $statement;
    /**
     * @var \PHPStan\Analyser\MutatingScope
     */
    private $scope;
    public function __construct(\PhpParser\Node\Stmt $statement, \PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
