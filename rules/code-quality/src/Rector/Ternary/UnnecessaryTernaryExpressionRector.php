<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\AssignAndBinaryMap;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Ternary\UnnecessaryTernaryExpressionRector\UnnecessaryTernaryExpressionRectorTest
 */
final class UnnecessaryTernaryExpressionRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssignAndBinaryMap
     */
    private $assignAndBinaryMap;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\AssignAndBinaryMap $assignAndBinaryMap)
    {
        $this->assignAndBinaryMap = $assignAndBinaryMap;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unnecessary ternary expressions.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$foo === $bar ? true : false;', '$foo === $bar;')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        /** @var Ternary $ternaryExpression */
        $ternaryExpression = $node;
        if (!$ternaryExpression->if instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
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
        if (!$condition instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
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
    private function processNonBinaryCondition(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $ifExpression, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $elseExpression, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $condition) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->isTrue($ifExpression) && $this->isFalse($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType::class)) {
                return $condition;
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($condition);
        }
        if ($this->isFalse($ifExpression) && $this->isTrue($elseExpression)) {
            if ($this->isStaticType($condition, \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType::class)) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($condition);
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_($condition));
        }
        return null;
    }
}
