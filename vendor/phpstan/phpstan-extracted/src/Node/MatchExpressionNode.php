<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Expr;
use PhpParser\NodeAbstract;
use PHPStan\Analyser\Scope;
class MatchExpressionNode extends \PhpParser\NodeAbstract implements \PHPStan\Node\VirtualNode
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
    public function __construct(\PhpParser\Node\Expr $condition, array $arms, \PhpParser\Node\Expr\Match_ $originalNode, \PHPStan\Analyser\Scope $endScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->condition = $condition;
        $this->arms = $arms;
        $this->endScope = $endScope;
    }
    public function getCondition() : \PhpParser\Node\Expr
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
    public function getEndScope() : \PHPStan\Analyser\Scope
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
