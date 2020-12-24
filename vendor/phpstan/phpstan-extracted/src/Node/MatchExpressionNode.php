<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
class MatchExpressionNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $condition, array $arms, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Match_ $originalNode, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $endScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->condition = $condition;
        $this->arms = $arms;
        $this->endScope = $endScope;
    }
    public function getCondition() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
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
    public function getEndScope() : \_PhpScopere8e811afab72\PHPStan\Analyser\Scope
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
