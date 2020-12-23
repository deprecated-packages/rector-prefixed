<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php80\Rector\Switch_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Match_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\MatchArm;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Case_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/match_expression_v2
 *
 * @see \Rector\Php80\Tests\Rector\Switch_\ChangeSwitchToMatchRector\ChangeSwitchToMatchRectorTest
 */
final class ChangeSwitchToMatchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var Expr|null
     */
    private $assignExpr;
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change switch() to match()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $statement = switch ($this->lexer->lookahead['type']) {
            case Lexer::T_SELECT:
                $statement = $this->SelectStatement();
                break;

            case Lexer::T_UPDATE:
                $statement = $this->UpdateStatement();
                break;

            case Lexer::T_DELETE:
                $statement = $this->DeleteStatement();
                break;

            default:
                $this->syntaxError('SELECT, UPDATE or DELETE');
                break;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $statement = match ($this->lexer->lookahead['type']) {
            Lexer::T_SELECT => $this->SelectStatement(),
            Lexer::T_UPDATE => $this->UpdateStatement(),
            Lexer::T_DELETE => $this->DeleteStatement(),
            default => $this->syntaxError('SELECT, UPDATE or DELETE'),
        };
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $this->assignExpr = null;
        if (!$this->hasEachCaseBreak($node)) {
            return null;
        }
        if (!$this->hasSingleStmtCases($node)) {
            return null;
        }
        if (!$this->hasSingleAssignVariableInStmtCase($node)) {
            return null;
        }
        $matchArms = $this->createMatchArmsFromCases($node->cases);
        $match = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Match_($node->cond, $matchArms);
        if ($this->assignExpr) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($this->assignExpr, $match);
        }
        return $match;
    }
    private function hasEachCaseBreak(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            foreach ($case->stmts as $caseStmt) {
                if (!$caseStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_) {
                    continue;
                }
                return \true;
            }
        }
        return \false;
    }
    private function hasSingleStmtCases(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        foreach ($switch->cases as $case) {
            $stmtsWithoutBreak = \array_filter($case->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
                return !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Break_;
            });
            if (\count($stmtsWithoutBreak) !== 1) {
                return \false;
            }
        }
        return \true;
    }
    private function hasSingleAssignVariableInStmtCase(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Switch_ $switch) : bool
    {
        $assignVariableNames = [];
        foreach ($switch->cases as $case) {
            /** @var Expression $onlyStmt */
            $onlyStmt = $case->stmts[0];
            $expr = $onlyStmt->expr;
            if (!$expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                continue;
            }
            $assignVariableNames[] = $this->getName($expr->var);
        }
        $assignVariableNames = \array_unique($assignVariableNames);
        return \count($assignVariableNames) <= 1;
    }
    /**
     * @param Case_[] $cases
     * @return MatchArm[]
     */
    private function createMatchArmsFromCases(array $cases) : array
    {
        $matchArms = [];
        foreach ($cases as $case) {
            $stmt = $case->stmts[0];
            if (!$stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
            }
            $expr = $stmt->expr;
            if ($expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                $this->assignExpr = $expr->var;
                $expr = $expr->expr;
            }
            $condList = $case->cond === null ? null : [$case->cond];
            $matchArms[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\MatchArm($condList, $expr);
        }
        return $matchArms;
    }
}
