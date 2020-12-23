<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Exit_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\ConstFetchManipulator $constFetchManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\StmtsManipulator $stmtsManipulator)
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
    public function matchIfNotNullReturnValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $stmts = (array) $if->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $insideIfNode = $stmts[0];
        if (!$insideIfNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
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
    public function matchIfNotNullNextAssignment(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        if ($if->stmts === []) {
            return null;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical || !$this->isNotIdenticalNullCompare($if->cond)) {
            return null;
        }
        $insideIfNode = $if->stmts[0];
        if (!$insideIfNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression || !$insideIfNode->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
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
    public function matchIfValueReturnValue(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        $stmts = (array) $if->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $insideIfNode = $stmts[0];
        if (!$insideIfNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
            return null;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
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
    public function collectNestedIfsWithOnlyReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : array
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
        if (!$this->hasOnlyStmtOfType($currentIf, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class)) {
            return [];
        }
        // last node is with the return value
        $ifs[] = $currentIf;
        return $ifs;
    }
    public function isIfAndElseWithSameVariableAssignAsLastStmts(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $desiredExpr) : bool
    {
        if ($if->else === null) {
            return \false;
        }
        if ((bool) $if->elseifs) {
            return \false;
        }
        $lastIfStmt = $this->stmtsManipulator->getUnwrappedLastStmt($if->stmts);
        if (!$lastIfStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        $lastElseStmt = $this->stmtsManipulator->getUnwrappedLastStmt($if->else->stmts);
        if (!$lastElseStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$lastIfStmt->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
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
    public function isIfOrIfElseWithFunctionCondition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, string $functionName) : bool
    {
        if ((bool) $if->elseifs) {
            return \false;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->nodeNameResolver->isName($if->cond, $functionName);
    }
    /**
     * @return If_[]
     */
    public function collectNestedIfsWithNonBreaking(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_ $foreach) : array
    {
        if (\count((array) $foreach->stmts) !== 1) {
            return [];
        }
        $onlyForeachStmt = $foreach->stmts[0];
        if (!$onlyForeachStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
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
        $betterNodeFinderFindInstanceOf = $this->betterNodeFinder->findInstanceOf($currentIf->stmts, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class);
        if ($betterNodeFinderFindInstanceOf !== []) {
            return [];
        }
        /** @var Exit_[] $exits */
        $exits = $this->betterNodeFinder->findInstanceOf($currentIf->stmts, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Exit_::class);
        if ($exits !== []) {
            return [];
        }
        // last node is with the expression
        $ifs[] = $currentIf;
        return $ifs;
    }
    public function isIfWithOnlyReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        if (!$this->isIfWithoutElseAndElseIfs($node)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class);
    }
    public function isIfWithOnlyForeach(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return \false;
        }
        if (!$this->isIfWithoutElseAndElseIfs($node)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Foreach_::class);
    }
    public function isIfWithOnlyOneStmt(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : bool
    {
        return \count((array) $if->stmts) === 1;
    }
    public function isIfCondUsingAssignIdenticalVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node $if, \_PhpScoper0a2ac50786fa\PhpParser\Node $assign) : bool
    {
        if (!($if instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ && $assign instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign)) {
            return \false;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            return \false;
        }
        return $this->betterStandardPrinter->areNodesEqual($this->getIfVar($if), $assign->var);
    }
    public function isIfCondUsingAssignNotIdenticalVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, \_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$if->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return \false;
        }
        return !$this->betterStandardPrinter->areNodesEqual($this->getIfVar($if), $node->var);
    }
    private function matchComparedAndReturnedNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
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
    private function isNotIdenticalNullCompare(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical $notIdentical) : bool
    {
        if ($this->betterStandardPrinter->areNodesEqual($notIdentical->left, $notIdentical->right)) {
            return \false;
        }
        return $this->constFetchManipulator->isNull($notIdentical->right) || $this->constFetchManipulator->isNull($notIdentical->left);
    }
    private function isIfWithOnlyStmtIf(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if (!$this->isIfWithoutElseAndElseIfs($if)) {
            return \false;
        }
        return $this->hasOnlyStmtOfType($if, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class);
    }
    private function hasOnlyStmtOfType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if, string $desiredType) : bool
    {
        $stmts = (array) $if->stmts;
        if (\count($stmts) !== 1) {
            return \false;
        }
        return \is_a($stmts[0], $desiredType);
    }
    private function isIfWithoutElseAndElseIfs(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else !== null) {
            return \false;
        }
        return !(bool) $if->elseifs;
    }
    private function getIfVar(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var Identical|NotIdentical $ifCond */
        $ifCond = $if->cond;
        return $this->constFetchManipulator->isNull($ifCond->left) ? $ifCond->right : $ifCond->left;
    }
}
