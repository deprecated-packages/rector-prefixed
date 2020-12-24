<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodeQuality\Rector\Ternary;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\UnnecessaryTernaryExpressionRector\UnnecessaryTernaryExpressionRectorTest
 */
final class UnnecessaryTernaryExpressionRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unnecessary ternary expressions.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$foo === $bar ? true : false;', '$foo === $bar;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        /** @var Ternary $ternaryExpression */
        $ternaryExpression = $node;
        if (!$ternaryExpression->if instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr) {
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
        if (!$condition instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp) {
            return $this->processNonBinaryCondition($ifExpression, $elseExpression, $condition);
        }
        if ($this->isNull($ifExpression)) {
            return null;
        }
        if ($this->isNull($elseExpression)) {
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
    private function processNonBinaryCondition(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $ifExpression, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $elseExpression, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $condition) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->isTrue($ifExpression) && $this->isFalse($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType::class)) {
                return $condition;
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_($condition);
        }
        if ($this->isFalse($ifExpression) && $this->isTrue($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType::class)) {
                return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot($condition);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_($condition));
        }
        return null;
    }
}
