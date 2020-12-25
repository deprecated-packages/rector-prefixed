<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeNameResolver\NodeNameResolver;
final class IfManipulator
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ConstFetchManipulator
     */
    private $constFetchManipulator;
    /**
     * @var StmtsManipulator
     */
    private $stmtsManipulator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator $stmtsManipulator)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->constFetchManipulator = $constFetchManipulator;
        $this->stmtsManipulator = $stmtsManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->betterNodeFinder = $betterNodeFinder;
    }
    /**
     * Matches:
     *
     * if (<$value> !== null) {
     *     return $value;
     * }
     */
    public function matchIfNotNullReturnValue(\PhpParser\Node\Stmt\If_ $if) : ?\PhpParser\Node\Expr
    {
        $stmts = $if->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $insideIfNode = $stmts[0];
        if (!$insideIfNode instanceof \PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return null;
        }
        return $this->matchComparedAndReturnedNode($if->cond, $insideIfNode);
    }
    /**
     * Matches:
     *
     * if (<$value> !== null) {
     *     $anotherValue = $value;
     * }
     */
    public function matchIfNotNullNextAssignment(\PhpParser\Node\Stmt\If_ $if) : ?\PhpParser\Node\Expr\Assign
    {
        if ($if->stmts === []) {
            return null;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return null;
        }
        if (!$this->isNotIdenticalNullCompare($if->cond)) {
            return null;
        }
        $insideIfNode = $if->stmts[0];
        if (!$insideIfNode instanceof \PhpParser\Node\Stmt\Expression) {
            return null;
        }
        if (!$insideIfNode->expr instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $insideIfNode->expr;
    }
    /**
     * Matches:
     *
     * if (<$value> === null) {
     *     return null;
     * }
     *
     * if (<$value> === 53;) {
     *     return 53;
     * }
     */
    public function matchIfValueReturnValue(\PhpParser\Node\Stmt\If_ $if) : ?\PhpParser\Node\Expr
    {
        $stmts = $if->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $insideIfNode = $stmts[0];
        if (!$insideIfNode instanceof \PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return null;
        }
        if ($this->betterStandardPrinter->areNodesEqual($if->cond->left, $insideIfNode->expr)) {
            return $if->cond->right;
        }
        if ($this->betterStandardPrinter->areNodesEqual($if->cond->right, $insideIfNode->expr)) {
            return $if->cond->left;
        }
        return null;
    }
    /**
     * @return mixed[]
     */
    public function collectNestedIfsWithOnlyReturn(\PhpParser\Node\Stmt\If_ $if) : array
    {
        $ifs = [];
        $currentIf = $if;
        while ($this->isIfWithOnlyStmtIf($currentIf)) {
            $ifs[] = $currentIf;
            $currentIf = $currentIf->stmts[0];
        }
        if ($ifs === []) {
            return [];
        }
        if (!$this->hasOnlyStmtOfType($currentIf, \PhpParser\Node\Stmt\Return_::class)) {
            return [];
        }
        // last node is with the return value
        $ifs[] = $currentIf;
        return $ifs;
    }
    public function isIfAndElseWithSameVariableAssignAsLastStmts(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node\Expr $desiredExpr) : bool
    {
        if ($if->else === null) {
            return \false;
        }
        if ((bool) $if->elseifs) {
            return \false;
        }
        $lastIfStmt = $this->stmtsManipulator->getUnwrappedLastStmt($if->stmts);
        if (!$lastIfStmt instanceof \PhpParser\Node\Expr\Assign) {
            return \false;
        }
        $lastElseStmt = $this->stmtsManipulator->getUnwrappedLastStmt($if->else->stmts);
        if (!$lastElseStmt instanceof \PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$lastIfStmt->var instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if (!$this->betterStandardPrinter->areNodesEqual($lastIfStmt->var, $lastElseStmt->var)) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($desiredExpr, $lastElseStmt->var);
    }
    /**
     * Matches:
     * if (<some_function>) {
     * } else {
     * }
     */
    public function isIfOrIfElseWithFunctionCondition(\PhpParser\Node\Stmt\If_ $if, string $functionName) : bool
    {
        if ((bool) $if->elseifs) {
            return \false;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($if->cond, $functionName);
    }
    /**
     * @return If_[]
     */
    public function collectNestedIfsWithNonBreaking(\PhpParser\Node\Stmt\Foreach_ $foreach) : array
    {
        if (\count($foreach->stmts) !== 1) {
            return [];
        }
        $onlyForeachStmt = $foreach->stmts[0];
        if (!$onlyForeachStmt instanceof \PhpParser\Node\Stmt\If_) {
            return [];
        }
        $ifs = [];
        $currentIf = $onlyForeachStmt;
        while ($this->isIfWithOnlyStmtIf($currentIf)) {
            $ifs[] = $currentIf;
            $currentIf = $currentIf->stmts[0];
        }
        // IfManipulator is not build to handle elseif and else
        if (!$this->isIfWithoutElseAndElseIfs($currentIf)) {
            return [];
        }
        $betterNodeFinderFindInstanceOf = $this->betterNodeFinder->findInstanceOf($currentIf->stmts, \PhpParser\Node\Stmt\Return_::class);
        if ($betterNodeFinderFindInstanceOf !== []) {
            return [];
        }
        /** @var Exit_[] $exits */
        $exits = $this->betterNodeFinder->findInstanceOf($currentIf->stmts, \PhpParser\Node\Expr\Exit_::class);
        if ($exits !== []) {
            return [];
        }
        // last node is with the expression
        $ifs[] = $currentIf;
        return $ifs;
    }
    public function isIfWithOnlyReturn(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Stmt\If_) {
            return \false;
        }
        if (!$this->isIfWithoutElseAndElseIfs($node)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($node, \PhpParser\Node\Stmt\Return_::class);
    }
    public function isIfWithOnlyForeach(\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Stmt\If_) {
            return \false;
        }
        if (!$this->isIfWithoutElseAndElseIfs($node)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($node, \PhpParser\Node\Stmt\Foreach_::class);
    }
    public function isIfWithOnlyOneStmt(\PhpParser\Node\Stmt\If_ $if) : bool
    {
        return \count($if->stmts) === 1;
    }
    public function isIfCondUsingAssignIdenticalVariable(\PhpParser\Node $if, \PhpParser\Node $assign) : bool
    {
        if (!($if instanceof \PhpParser\Node\Stmt\If_ && $assign instanceof \PhpParser\Node\Expr\Assign)) {
            return \false;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($this->getIfCondVar($if), $assign->var);
    }
    public function isIfCondUsingAssignNotIdenticalVariable(\PhpParser\Node\Stmt\If_ $if, \PhpParser\Node $node) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall && !$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$if->cond instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return \false;
        }
        return !$this->betterStandardPrinter->areNodesEqual($this->getIfCondVar($if), $node->var);
    }
    private function matchComparedAndReturnedNode(\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical, \PhpParser\Node\Stmt\Return_ $return) : ?\PhpParser\Node\Expr
    {
        if ($this->betterStandardPrinter->areNodesEqual($notIdentical->left, $return->expr) && $this->constFetchManipulator->isNull($notIdentical->right)) {
            return $notIdentical->left;
        }
        if (!$this->betterStandardPrinter->areNodesEqual($notIdentical->right, $return->expr)) {
            return null;
        }
        if ($this->constFetchManipulator->isNull($notIdentical->left)) {
            return $notIdentical->right;
        }
        return null;
    }
    private function isNotIdenticalNullCompare(\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : bool
    {
        if ($this->betterStandardPrinter->areNodesEqual($notIdentical->left, $notIdentical->right)) {
            return \false;
        }
        return $this->constFetchManipulator->isNull($notIdentical->right) || $this->constFetchManipulator->isNull($notIdentical->left);
    }
    private function isIfWithOnlyStmtIf(\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if (!$this->isIfWithoutElseAndElseIfs($if)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($if, \PhpParser\Node\Stmt\If_::class);
    }
    private function hasOnlyStmtOfType(\PhpParser\Node\Stmt\If_ $if, string $desiredType) : bool
    {
        $stmts = $if->stmts;
        if (\count($stmts) !== 1) {
            return \false;
        }
        return \is_a($stmts[0], $desiredType);
    }
    private function isIfWithoutElseAndElseIfs(\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else !== null) {
            return \false;
        }
        return !(bool) $if->elseifs;
    }
    private function getIfCondVar(\PhpParser\Node\Stmt\If_ $if) : \PhpParser\Node
    {
        /** @var Identical|NotIdentical $ifCond */
        $ifCond = $if->cond;
        return $this->constFetchManipulator->isNull($ifCond->left) ? $ifCond->right : $ifCond->left;
    }
}
