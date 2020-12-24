<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Ternary;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\UnnecessaryTernaryExpressionRector\UnnecessaryTernaryExpressionRectorTest
 */
final class UnnecessaryTernaryExpressionRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unnecessary ternary expressions.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$foo === $bar ? true : false;', '$foo === $bar;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var Ternary $ternaryExpression */
        $ternaryExpression = $node;
        if (!$ternaryExpression->if instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
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
        if (!$condition instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp) {
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
    private function processNonBinaryCondition(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $ifExpression, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $elseExpression, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $condition) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->isTrue($ifExpression) && $this->isFalse($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class)) {
                return $condition;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_($condition);
        }
        if ($this->isFalse($ifExpression) && $this->isTrue($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class)) {
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($condition);
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_($condition));
        }
        return null;
    }
}
