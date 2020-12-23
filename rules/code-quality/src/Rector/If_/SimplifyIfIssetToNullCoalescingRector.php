<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Else_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\SimplifyIfIssetToNullCoalescingRector\SimplifyIfIssetToNullCoalescingRectorTest
 */
final class SimplifyIfIssetToNullCoalescingRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify binary if to null coalesce', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function run($possibleStatieYamlFile)
    {
        if (isset($possibleStatieYamlFile['import'])) {
            $possibleStatieYamlFile['import'] = array_merge($possibleStatieYamlFile['import'], $filesToImport);
        } else {
            $possibleStatieYamlFile['import'] = $filesToImport;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function run($possibleStatieYamlFile)
    {
        $possibleStatieYamlFile['import'] = array_merge($possibleStatieYamlFile['import'] ?? [], $filesToImport);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Isset_ $issetNode */
        $issetNode = $node->cond;
        $valueNode = $issetNode->vars[0];
        // various scenarios
        $ifFirstStmt = $node->stmts[0];
        if (!$ifFirstStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $else = $node->else;
        if (!$else instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Else_) {
            return null;
        }
        $elseFirstStmt = $else->stmts[0];
        if (!$elseFirstStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        /** @var Assign $firstAssign */
        $firstAssign = $ifFirstStmt->expr;
        /** @var Assign $secondAssign */
        $secondAssign = $elseFirstStmt->expr;
        // 1. array_merge
        if (!$firstAssign->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return null;
        }
        if (!$this->isName($firstAssign->expr, 'array_merge')) {
            return null;
        }
        if (!$this->areNodesEqual($firstAssign->expr->args[0]->value, $valueNode)) {
            return null;
        }
        if (!$this->areNodesEqual($secondAssign->expr, $firstAssign->expr->args[1]->value)) {
            return null;
        }
        $args = [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce($valueNode, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]))), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($secondAssign->expr)];
        $funcCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('array_merge'), $args);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign($valueNode, $funcCall);
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else === null) {
            return \true;
        }
        if (\count((array) $if->elseifs) > 1) {
            return \true;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_) {
            return \true;
        }
        if (!$this->hasOnlyStatementAssign($if)) {
            return \true;
        }
        if (!$this->hasOnlyStatementAssign($if->else)) {
            return \true;
        }
        $ifStmt = $if->stmts[0];
        if (!$ifStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \true;
        }
        if (!$ifStmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        if (!$this->areNodesEqual($if->cond->vars[0], $ifStmt->expr->var)) {
            return \true;
        }
        $firstElseStmt = $if->else->stmts[0];
        if (!$firstElseStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        if (!$firstElseStmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        return !$this->areNodesEqual($if->cond->vars[0], $firstElseStmt->expr->var);
    }
    /**
     * @param If_|Else_ $node
     */
    private function hasOnlyStatementAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (\count((array) $node->stmts) !== 1) {
            return \false;
        }
        if (!$node->stmts[0] instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        return $node->stmts[0]->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
    }
}
