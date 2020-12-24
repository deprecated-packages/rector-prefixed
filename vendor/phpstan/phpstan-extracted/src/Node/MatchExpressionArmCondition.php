<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
class MatchExpressionArmCondition
{
    /** @var Expr */
    private $condition;
    /** @var Scope */
    private $scope;
    /** @var int */
    private $line;
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $condition, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, int $line)
    {
        $this->condition = $condition;
        $this->scope = $scope;
        $this->line = $line;
    }
    public function getCondition() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->condition;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope
    {
        return $this->scope;
    }
    public function getLine() : int
    {
        return $this->line;
    }
}
