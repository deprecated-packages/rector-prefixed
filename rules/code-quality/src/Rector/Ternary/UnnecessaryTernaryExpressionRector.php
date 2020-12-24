<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Ternary;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\UnnecessaryTernaryExpressionRector\UnnecessaryTernaryExpressionRectorTest
 */
final class UnnecessaryTernaryExpressionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unnecessary ternary expressions.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$foo === $bar ? true : false;', '$foo === $bar;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Ternary $ternaryExpression */
        $ternaryExpression = $node;
        if (!$ternaryExpression->if instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return null;
        }
        $ifExpression = $ternaryExpression->if;
        if (!$this->isBool($ifExpression)) {
            return null;
        }
        $elseExpression = $ternaryExpression->else;
        if (!$this->isBool($elseExpression)) {
            return null;
        }
        $condition = $ternaryExpression->cond;
        if (!$condition instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp) {
            return $this->processNonBinaryCondition($ifExpression, $elseExpression, $condition);
        }
        if ($this->isNull($ifExpression) || $this->isNull($elseExpression)) {
            return null;
        }
        /** @var BinaryOp $binaryOperation */
        $binaryOperation = $node->cond;
        if ($this->isTrue($ifExpression) && $this->isFalse($elseExpression)) {
            return $binaryOperation;
        }
        $inversedBinaryClass = $this->assignAndBinaryMap->getInversed($binaryOperation);
        if ($inversedBinaryClass === null) {
            return null;
        }
        return new $inversedBinaryClass($binaryOperation->left, $binaryOperation->right);
    }
    private function processNonBinaryCondition(\_PhpScopere8e811afab72\PhpParser\Node\Expr $ifExpression, \_PhpScopere8e811afab72\PhpParser\Node\Expr $elseExpression, \_PhpScopere8e811afab72\PhpParser\Node\Expr $condition) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->isTrue($ifExpression) && $this->isFalse($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
                return $condition;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_($condition);
        }
        if ($this->isFalse($ifExpression) && $this->isTrue($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($condition);
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_($condition));
        }
        return null;
    }
}
