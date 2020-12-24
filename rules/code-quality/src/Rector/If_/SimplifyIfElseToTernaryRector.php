<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\If_;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\SimplifyIfElseToTernaryRector\SimplifyIfElseToTernaryRectorTest
 */
final class SimplifyIfElseToTernaryRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var int
     */
    private const LINE_LENGHT_LIMIT = 120;
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes if/else for same value as assign to ternary', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (empty($value)) {
            $this->arrayBuilt[][$key] = true;
        } else {
            $this->arrayBuilt[][$key] = $value;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->arrayBuilt[][$key] = empty($value) ? true : $value;
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node->else === null) {
            return null;
        }
        if ($node->elseifs !== []) {
            return null;
        }
        $ifAssignVar = $this->resolveOnlyStmtAssignVar($node->stmts);
        $elseAssignVar = $this->resolveOnlyStmtAssignVar($node->else->stmts);
        if ($ifAssignVar === null || $elseAssignVar === null) {
            return null;
        }
        if (!$this->areNodesEqual($ifAssignVar, $elseAssignVar)) {
            return null;
        }
        $ternaryIf = $this->resolveOnlyStmtAssignExpr($node->stmts);
        $ternaryElse = $this->resolveOnlyStmtAssignExpr($node->else->stmts);
        if ($ternaryIf === null || $ternaryElse === null) {
            return null;
        }
        // has nested ternary → skip, it's super hard to read
        if ($this->haveNestedTernary([$node->cond, $ternaryIf, $ternaryElse])) {
            return null;
        }
        $ternary = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary($node->cond, $ternaryIf, $ternaryElse);
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($ifAssignVar, $ternary);
        // do not create super long lines
        if ($this->isNodeTooLong($assign)) {
            return null;
        }
        return $assign;
    }
    /**
     * @param Stmt[] $stmts
     */
    private function resolveOnlyStmtAssignVar(array $stmts) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $this->unwrapExpression($stmts[0]);
        if (!$onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $onlyStmt->var;
    }
    /**
     * @param Stmt[] $stmts
     */
    private function resolveOnlyStmtAssignExpr(array $stmts) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $this->unwrapExpression($stmts[0]);
        if (!$onlyStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $onlyStmt->expr;
    }
    /**
     * @param Node[] $nodes
     */
    private function haveNestedTernary(array $nodes) : bool
    {
        foreach ($nodes as $node) {
            $betterNodeFinderFindInstanceOf = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary::class);
            if ($betterNodeFinderFindInstanceOf !== []) {
                return \true;
            }
        }
        return \false;
    }
    private function isNodeTooLong(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : bool
    {
        return \_PhpScoperb75b35f52b74\Nette\Utils\Strings::length($this->print($assign)) > self::LINE_LENGHT_LIMIT;
    }
}
