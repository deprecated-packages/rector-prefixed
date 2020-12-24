<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Foreach_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ForeachManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/bfsdY
 *
 * @see \Rector\CodeQuality\Tests\Rector\Foreach_\SimplifyForeachToCoalescingRector\SimplifyForeachToCoalescingRectorTest
 */
final class SimplifyForeachToCoalescingRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ForeachManipulator
     */
    private $foreachManipulator;
    /**
     * @var Return_|null
     */
    private $return;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ForeachManipulator $foreachManipulator)
    {
        $this->foreachManipulator = $foreachManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes foreach that returns set value to ??', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
foreach ($this->oldToNewFunctions as $oldFunction => $newFunction) {
    if ($currentFunction === $oldFunction) {
        return $newFunction;
    }
}

return null;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
return $this->oldToNewFunctions[$currentFunction] ?? null;
CODE_SAMPLE
)]);
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
        if (!$this->isAtLeastPhpVersion(\_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::NULL_COALESCE)) {
            return null;
        }
        $this->return = null;
        if ($node->keyVar === null) {
            return null;
        }
        /** @var Return_|Assign|null $returnOrAssignNode */
        $returnOrAssignNode = $this->matchReturnOrAssignNode($node);
        if ($returnOrAssignNode === null) {
            return null;
        }
        // return $newValue;
        // we don't return the node value
        if (!$this->areNodesEqual($node->valueVar, $returnOrAssignNode->expr)) {
            return null;
        }
        if ($returnOrAssignNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            return $this->processForeachNodeWithReturnInside($node, $returnOrAssignNode);
        }
        return $this->processForeachNodeWithAssignInside($node, $returnOrAssignNode);
    }
    /**
     * @return Assign|Return_|null
     */
    private function matchReturnOrAssignNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->foreachManipulator->matchOnlyStmt($foreach, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
                return null;
            }
            if (!$node->cond instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
                return null;
            }
            if (\count((array) $node->stmts) !== 1) {
                return null;
            }
            $innerNode = $node->stmts[0] instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression ? $node->stmts[0]->expr : $node->stmts[0];
            if ($innerNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign || $innerNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                return $innerNode;
            }
            return null;
        });
    }
    private function processForeachNodeWithReturnInside(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->areNodesEqual($foreach->valueVar, $return->expr)) {
            return null;
        }
        /** @var If_ $ifNode */
        $ifNode = $foreach->stmts[0];
        /** @var Identical $identicalNode */
        $identicalNode = $ifNode->cond;
        if ($this->areNodesEqual($identicalNode->left, $foreach->keyVar)) {
            $checkedNode = $identicalNode->right;
        } elseif ($this->areNodesEqual($identicalNode->right, $foreach->keyVar)) {
            $checkedNode = $identicalNode->left;
        } else {
            return null;
        }
        $nextNode = $foreach->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        // is next node Return?
        if ($nextNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            $this->return = $nextNode;
            $this->removeNode($this->return);
        }
        $coalesce = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($foreach->expr, $checkedNode), $this->return && $this->return->expr !== null ? $this->return->expr : $checkedNode);
        if ($this->return !== null) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_($coalesce);
        }
        return null;
    }
    private function processForeachNodeWithAssignInside(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var If_ $ifNode */
        $ifNode = $foreach->stmts[0];
        /** @var Identical $identicalNode */
        $identicalNode = $ifNode->cond;
        if ($this->areNodesEqual($identicalNode->left, $foreach->keyVar)) {
            $checkedNode = $assign->var;
            $keyNode = $identicalNode->right;
        } elseif ($this->areNodesEqual($identicalNode->right, $foreach->keyVar)) {
            $checkedNode = $assign->var;
            $keyNode = $identicalNode->left;
        } else {
            return null;
        }
        $arrayDimFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($foreach->expr, $keyNode);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($checkedNode, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce($arrayDimFetch, $checkedNode));
    }
}
