<?php

declare (strict_types=1);
namespace Rector\NodeNestingScope;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Else_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNestingScope\ValueObject\ControlStructure;
final class ScopeNestingComparator
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    /**
     * @var Expr[]
     */
    private $doubleIfBranchExprs = [];
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeComparator = $nodeComparator;
    }
    public function areReturnScopeNested(\PhpParser\Node\Stmt\Return_ $return, \PhpParser\Node $secondNodeScopeNode) : bool
    {
        $firstNodeScopeNode = $this->betterNodeFinder->findParentTypes($return, \Rector\NodeNestingScope\ValueObject\ControlStructure::RETURN_ISOLATING_SCOPE_NODE_TYPES);
        return $this->nodeComparator->areNodesEqual($firstNodeScopeNode, $secondNodeScopeNode);
    }
    public function areScopeNestingEqual(\PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        $firstNodeScopeNode = $this->findParentControlStructure($firstNode);
        $secondNodeScopeNode = $this->findParentControlStructure($secondNode);
        return $this->nodeComparator->areNodesEqual($firstNodeScopeNode, $secondNodeScopeNode);
    }
    public function isNodeConditionallyScoped(\PhpParser\Node\Expr $expr) : bool
    {
        $foundParent = $this->betterNodeFinder->findParentTypes($expr, \Rector\NodeNestingScope\ValueObject\ControlStructure::CONDITIONAL_NODE_SCOPE_TYPES + [\PhpParser\Node\FunctionLike::class]);
        if (!$foundParent instanceof \PhpParser\Node) {
            return \false;
        }
        // is in both if/else branches
        if ($this->isInBothIfElseBranch($foundParent, $expr)) {
            return \false;
        }
        if ($foundParent instanceof \PhpParser\Node\Stmt\Else_ && $this->nodeComparator->areNodesEqual($expr, $this->doubleIfBranchExprs)) {
            return \false;
        }
        return !$foundParent instanceof \PhpParser\Node\FunctionLike;
    }
    public function isInBothIfElseBranch(\PhpParser\Node $foundParentNode, \PhpParser\Node\Expr $seekedExpr) : bool
    {
        if ($foundParentNode instanceof \PhpParser\Node\Stmt\Else_) {
            return $this->nodeComparator->isNodeEqual($seekedExpr, $this->doubleIfBranchExprs);
        }
        if (!$foundParentNode instanceof \PhpParser\Node\Stmt\If_) {
            return \false;
        }
        $foundIfNode = $this->betterNodeFinder->find($foundParentNode->stmts, function ($node) use($seekedExpr) : bool {
            return $this->nodeComparator->areNodesEqual($node, $seekedExpr);
        });
        if ($foundParentNode->else === null) {
            return \false;
        }
        $foundElseNode = $this->betterNodeFinder->find($foundParentNode->else, function ($node) use($seekedExpr) : bool {
            return $this->nodeComparator->areNodesEqual($node, $seekedExpr);
        });
        if ($foundIfNode && $foundElseNode) {
            $this->doubleIfBranchExprs[] = $seekedExpr;
            return \true;
        }
        return \false;
    }
    private function findParentControlStructure(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        return $this->betterNodeFinder->findParentTypes($node, \Rector\NodeNestingScope\ValueObject\ControlStructure::BREAKING_SCOPE_NODE_TYPES);
    }
}
