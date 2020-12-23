<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\NodeAbstract;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
class MatchExpressionNode extends \_PhpScoper0a2ac50786fa\PhpParser\NodeAbstract implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var Expr */
    private $condition;
    /** @var MatchExpressionArm[] */
    private $arms;
    /** @var Scope */
    private $endScope;
    /**
     * @param Expr $condition
     * @param MatchExpressionArm[] $arms
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $condition, array $arms, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Match_ $originalNode, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $endScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->condition = $condition;
        $this->arms = $arms;
        $this->endScope = $endScope;
    }
    public function getCondition() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $this->condition;
    }
    /**
     * @return MatchExpressionArm[]
     */
    public function getArms() : array
    {
        return $this->arms;
    }
    public function getEndScope() : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope
    {
        return $this->endScope;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_MatchExpression';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
