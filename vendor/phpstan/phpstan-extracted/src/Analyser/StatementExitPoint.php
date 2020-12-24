<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
class StatementExitPoint
{
    /** @var Stmt */
    private $statement;
    /** @var MutatingScope */
    private $scope;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $statement, \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope $scope)
    {
        $this->statement = $statement;
        $this->scope = $scope;
    }
    public function getStatement() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt
    {
        return $this->statement;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope
    {
        return $this->scope;
    }
}
