<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Expression;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Match_;
use _PhpScopere8e811afab72\PhpParser\Node\MatchArm;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/match_expression_v2
 *
 * @see \Rector\DowngradePhp80\Tests\Rector\Expression\DowngradeMatchToSwitchRector\DowngradeMatchToSwitchRectorTest
 */
final class DowngradeMatchToSwitchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade match() to switch()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $message = match ($statusCode) {
            200, 300 => null,
            400 => 'not found',
            default => 'unknown status code',
        };
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        switch ($statusCode) {
            case 200:
            case 300:
                $message = null;
                break;
            case 400:
                $message = 'not found';
                break;
            default:
                $message = 'unknown status code';
                break;
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class];
    }
    /**
     * @param Expression $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $assign = $node->expr;
        if (!$assign->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Match_) {
            return null;
        }
        /** @var Match_ $match */
        $match = $assign->expr;
        $switchCases = $this->createSwitchCasesFromMatchArms((array) $match->arms, $assign->var);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Switch_($match->cond, $switchCases);
    }
    /**
     * @param MatchArm[] $matchArms
     * @return Case_[]
     */
    private function createSwitchCasesFromMatchArms(array $matchArms, \_PhpScopere8e811afab72\PhpParser\Node\Expr $assignVarExpr) : array
    {
        $switchCases = [];
        foreach ($matchArms as $matchArm) {
            if (\count((array) $matchArm->conds) > 1) {
                $lastCase = null;
                foreach ((array) $matchArm->conds as $matchArmCond) {
                    $lastCase = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_($matchArmCond);
                    $switchCases[] = $lastCase;
                }
                if (!$lastCase instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_) {
                    throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
                }
                $lastCase->stmts = $this->createSwitchStmts($matchArm, $assignVarExpr);
            } else {
                $stmts = $this->createSwitchStmts($matchArm, $assignVarExpr);
                $switchCases[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Case_($matchArm->conds[0] ?? null, $stmts);
            }
        }
        return $switchCases;
    }
    /**
     * @return Stmt[]
     */
    private function createSwitchStmts(\_PhpScopere8e811afab72\PhpParser\Node\MatchArm $matchArm, \_PhpScopere8e811afab72\PhpParser\Node\Expr $assignVarExpr) : array
    {
        $stmts = [];
        $stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($assignVarExpr, $matchArm->body));
        $stmts[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_();
        return $stmts;
    }
}
