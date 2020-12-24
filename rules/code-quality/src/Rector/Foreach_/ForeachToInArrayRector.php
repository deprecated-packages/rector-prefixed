<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Foreach_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Comment\CommentsMerger;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\ForeachToInArrayRector\ForeachToInArrayRectorTest
 */
final class ForeachToInArrayRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    /**
     * @var CommentsMerger
     */
    private $commentsMerger;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger)
    {
        $this->binaryOpManipulator = $binaryOpManipulator;
        $this->commentsMerger = $commentsMerger;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Simplify `foreach` loops into `in_array` when possible', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
foreach ($items as $item) {
    if ($item === 'something') {
        return true;
    }
}

return false;
CODE_SAMPLE
, 'in_array("something", $items, true);')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->shouldSkipForeach($node)) {
            return null;
        }
        /** @var If_ $firstNodeInsideForeach */
        $firstNodeInsideForeach = $node->stmts[0];
        if ($this->shouldSkipIf($firstNodeInsideForeach)) {
            return null;
        }
        /** @var Identical|Equal $ifCondition */
        $ifCondition = $firstNodeInsideForeach->cond;
        $foreachValueVar = $node->valueVar;
        $twoNodeMatch = $this->matchNodes($ifCondition, $foreachValueVar);
        if ($twoNodeMatch === null) {
            return null;
        }
        $comparedNode = $twoNodeMatch->getSecondExpr();
        if (!$this->isIfBodyABoolReturnNode($firstNodeInsideForeach)) {
            return null;
        }
        $funcCall = $this->createInArrayFunction($comparedNode, $ifCondition, $node);
        /** @var Return_ $returnToRemove */
        $returnToRemove = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        /** @var Return_ $return */
        $return = $firstNodeInsideForeach->stmts[0];
        if ($returnToRemove->expr === null) {
            return null;
        }
        if (!$this->isBool($returnToRemove->expr)) {
            return null;
        }
        if ($return->expr === null) {
            return null;
        }
        // cannot be "return true;" + "return true;"
        if ($this->areNodesEqual($return, $returnToRemove)) {
            return null;
        }
        $this->removeNode($returnToRemove);
        $return = $this->createReturn($return->expr, $funcCall);
        $this->commentsMerger->keepChildren($return, $node);
        return $return;
    }
    private function shouldSkipForeach(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        if ($foreach->keyVar !== null) {
            return \true;
        }
        if (\count((array) $foreach->stmts) > 1) {
            return \true;
        }
        $nextNode = $foreach->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if ($nextNode === null || !$nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        $returnExpression = $nextNode->expr;
        if ($returnExpression === null) {
            return \true;
        }
        if (!$this->isBool($returnExpression)) {
            return \true;
        }
        $foreachValueStaticType = $this->getStaticType($foreach->expr);
        if ($foreachValueStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \true;
        }
        return !$foreach->stmts[0] instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
    }
    private function shouldSkipIf(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if) : bool
    {
        $ifCondition = $if->cond;
        if ($ifCondition instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            return \false;
        }
        return !$ifCondition instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Equal;
    }
    private function matchNodes(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch
    {
        return $this->binaryOpManipulator->matchFirstAndSecondConditionNode($binaryOp, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable::class, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node $otherNode) use($expr) : bool {
            return $this->areNodesEqual($otherNode, $expr);
        });
    }
    private function isIfBodyABoolReturnNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if) : bool
    {
        $ifStatment = $if->stmts[0];
        if (!$ifStatment instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        if ($ifStatment->expr === null) {
            return \false;
        }
        return $this->isBool($ifStatment->expr);
    }
    /**
     * @param Identical|Equal $binaryOp
     */
    private function createInArrayFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $arguments = $this->createArgs([$expr, $foreach->expr]);
        if ($binaryOp instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            $arguments[] = $this->createArg($this->createTrue());
        }
        return $this->createFuncCall('in_array', $arguments);
    }
    private function createReturn(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_
    {
        $expr = $this->isFalse($expr) ? new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($funcCall) : $funcCall;
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($expr);
    }
}
