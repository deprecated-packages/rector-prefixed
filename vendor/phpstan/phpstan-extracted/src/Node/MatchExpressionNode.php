<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
class MatchExpressionNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\VirtualNode
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $condition, array $arms, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Match_ $originalNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $endScope)
    {
        parent::__construct($originalNode->getAttributes());
        $this->condition = $condition;
        $this->arms = $arms;
        $this->endScope = $endScope;
    }
    public function getCondition() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
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
    public function getEndScope() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope
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
