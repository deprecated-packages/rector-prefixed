<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class MatchExpressionArmCondition
{
    /** @var Expr */
    private $condition;
    /** @var Scope */
    private $scope;
    /** @var int */
    private $line;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $condition, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, int $line)
    {
        $this->condition = $condition;
        $this->scope = $scope;
        $this->line = $line;
    }
    public function getCondition() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->condition;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getLine() : int
    {
        return $this->line;
    }
}
