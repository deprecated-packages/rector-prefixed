<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyBoolIdenticalTrueRector\SimplifyBoolIdenticalTrueRectorTest
 */
final class SimplifyBoolIdenticalTrueRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Symplify bool value compare to true or false', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(bool $value, string $items)
    {
         $match = in_array($value, $items, TRUE) === TRUE;
         $match = in_array($value, $items, TRUE) !== FALSE;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(bool $value, string $items)
    {
         $match = in_array($value, $items, TRUE);
         $match = in_array($value, $items, TRUE);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->isStaticType($node->left, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class) && !$this->isBool($node->left)) {
            return $this->processBoolTypeToNotBool($node, $node->left, $node->right);
        }
        if ($this->isStaticType($node->right, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class) && !$this->isBool($node->right)) {
            return $this->processBoolTypeToNotBool($node, $node->right, $node->left);
        }
        return null;
    }
    private function processBoolTypeToNotBool(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr $leftExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $rightExpr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($leftExpr, $rightExpr);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return $this->refactorNotIdentical($leftExpr, $rightExpr);
        }
        return null;
    }
    private function refactorIdentical(\_PhpScopere8e811afab72\PhpParser\Node\Expr $leftExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $rightExpr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isTrue($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isFalse($rightExpr)) {
            // prevent !!
            if ($leftExpr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
                return $leftExpr->expr;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
    private function refactorNotIdentical(\_PhpScopere8e811afab72\PhpParser\Node\Expr $leftExpr, \_PhpScopere8e811afab72\PhpParser\Node\Expr $rightExpr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isFalse($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isTrue($rightExpr)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
}
