<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $statement, \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
