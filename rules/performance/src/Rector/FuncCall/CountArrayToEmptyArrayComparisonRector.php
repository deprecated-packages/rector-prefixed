<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Performance\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Performance\Tests\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector\CountArrayToEmptyArrayComparisonRectorTest
 */
final class CountArrayToEmptyArrayComparisonRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change count array comparison to empty array comparison to improve performance', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
count($array) === 0;
count($array) > 0;
! count($array);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$array === [];
$array !== [];
$array === [];
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot::class];
    }
    /**
     * @param FuncCall|BooleanNot $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
            return $this->processMarkTruthyNegation($node);
        }
        if ($this->getName($node) !== 'count') {
            return null;
        }
        /** @var Expr $expr */
        $expr = $node->args[0]->value;
        // not pass array type, skip
        if (!$this->isArray($expr)) {
            return null;
        }
        $parent = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node) {
            return null;
        }
        $processIdentical = $this->processIdentical($parent, $node, $expr);
        if ($processIdentical !== null) {
            return $processIdentical;
        }
        $processGreaterOrSmaller = $this->processGreaterOrSmaller($parent, $node, $expr);
        if ($processGreaterOrSmaller !== null) {
            return $processGreaterOrSmaller;
        }
        return $this->processMarkTruthy($parent, $node, $expr);
    }
    private function processMarkTruthyNegation(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot $booleanNot) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical
    {
        if (!$booleanNot->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall || $this->getName($booleanNot->expr) !== 'count') {
            return null;
        }
        /** @var Expr $expr */
        $expr = $booleanNot->expr->args[0]->value;
        // not pass array type, skip
        if (!$this->isArray($expr)) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical($expr, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]));
    }
    private function isArray(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        /** @var Scope|null $scope */
        $scope = $expr->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope) {
            return \false;
        }
        return $scope->getType($expr) instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
    }
    private function processIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical && $node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber && $node->right->value === 0) {
            $this->removeNode($funcCall);
            $node->right = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]);
            return $expr;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical && $node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber && $node->left->value === 0) {
            $this->removeNode($funcCall);
            $node->left = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]);
            return $expr;
        }
        return null;
    }
    private function processGreaterOrSmaller(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater && $node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber && $node->right->value === 0) {
            $this->removeNode($funcCall);
            $this->removeNode($node->right);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]));
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller && $node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber && $node->left->value === 0) {
            $this->removeNode($funcCall);
            $this->removeNode($node->left);
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]), $expr);
        }
        return null;
    }
    private function processMarkTruthy(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_) {
            return null;
        }
        if ($node->cond === $funcCall) {
            $node->cond = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_([]));
            return $node->cond;
        }
        return null;
    }
}
