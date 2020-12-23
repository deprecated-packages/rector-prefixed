<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Performance\Rector\FuncCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Performance\Tests\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector\CountArrayToEmptyArrayComparisonRectorTest
 */
final class CountArrayToEmptyArrayComparisonRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change count array comparison to empty array comparison to improve performance', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot::class];
    }
    /**
     * @param FuncCall|BooleanNot $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot) {
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
        $parent = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node) {
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
    private function processMarkTruthyNegation(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot $booleanNot) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical
    {
        if (!$booleanNot->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall || $this->getName($booleanNot->expr) !== 'count') {
            return null;
        }
        /** @var Expr $expr */
        $expr = $booleanNot->expr->args[0]->value;
        // not pass array type, skip
        if (!$this->isArray($expr)) {
            return null;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($expr, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]));
    }
    private function isArray(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : bool
    {
        /** @var Scope|null $scope */
        $scope = $expr->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope) {
            return \false;
        }
        return $scope->getType($expr) instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
    }
    private function processIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical && $node->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber && $node->right->value === 0) {
            $this->removeNode($funcCall);
            $node->right = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]);
            return $expr;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical && $node->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber && $node->left->value === 0) {
            $this->removeNode($funcCall);
            $node->left = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]);
            return $expr;
        }
        return null;
    }
    private function processGreaterOrSmaller(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Greater && $node->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber && $node->right->value === 0) {
            $this->removeNode($funcCall);
            $this->removeNode($node->right);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]));
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Smaller && $node->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber && $node->left->value === 0) {
            $this->removeNode($funcCall);
            $this->removeNode($node->left);
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]), $expr);
        }
        return null;
    }
    private function processMarkTruthy(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_) {
            return null;
        }
        if ($node->cond === $funcCall) {
            $node->cond = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_([]));
            return $node->cond;
        }
        return null;
    }
}
