<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Foreach_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\If_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\SimplifyForeachToArrayFilterRector\SimplifyForeachToArrayFilterRectorTest
 */
final class SimplifyForeachToArrayFilterRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify foreach with function filtering to array filter', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$directories = [];
$possibleDirectories = [];
foreach ($possibleDirectories as $possibleDirectory) {
    if (file_exists($possibleDirectory)) {
        $directories[] = $possibleDirectory;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$possibleDirectories = [];
$directories = array_filter($possibleDirectories, 'file_exists');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var If_ $ifNode */
        $ifNode = $node->stmts[0];
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $ifNode->cond;
        if (\count((array) $ifNode->stmts) !== 1) {
            return null;
        }
        if (\count((array) $funcCallNode->args) !== 1) {
            return null;
        }
        if (!$this->areNodesEqual($funcCallNode->args[0], $node->valueVar)) {
            return null;
        }
        if (!$ifNode->stmts[0] instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        $onlyNodeInIf = $ifNode->stmts[0]->expr;
        if (!$onlyNodeInIf instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        if (!$onlyNodeInIf->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$this->areNodesEqual($onlyNodeInIf->expr, $node->valueVar)) {
            return null;
        }
        $name = $this->getName($funcCallNode);
        if ($name === null) {
            return null;
        }
        return $this->createAssignNode($node, $name, $onlyNodeInIf->var);
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        if (\count((array) $foreach->stmts) !== 1) {
            return \true;
        }
        if (!$foreach->stmts[0] instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\If_) {
            return \true;
        }
        /** @var If_ $ifNode */
        $ifNode = $foreach->stmts[0];
        if ($ifNode->else !== null) {
            return \true;
        }
        if ($ifNode->elseifs !== []) {
            return \true;
        }
        return !$ifNode->cond instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
    }
    private function createAssignNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach, string $name, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign
    {
        $string = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($name);
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($foreach->expr), new \_PhpScopere8e811afab72\PhpParser\Node\Arg($string)];
        $arrayFilterFuncCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('array_filter'), $args);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($arrayDimFetch->var, $arrayFilterFuncCall);
    }
}
