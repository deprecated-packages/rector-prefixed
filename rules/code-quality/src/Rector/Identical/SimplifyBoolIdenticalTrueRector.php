<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyBoolIdenticalTrueRector\SimplifyBoolIdenticalTrueRectorTest
 */
final class SimplifyBoolIdenticalTrueRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Symplify bool value compare to true or false', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($this->isStaticType($node->left, \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class) && !$this->isBool($node->left)) {
            return $this->processBoolTypeToNotBool($node, $node->left, $node->right);
        }
        if ($this->isStaticType($node->right, \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class) && !$this->isBool($node->right)) {
            return $this->processBoolTypeToNotBool($node, $node->right, $node->left);
        }
        return null;
    }
    private function processBoolTypeToNotBool(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $leftExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($leftExpr, $rightExpr);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return $this->refactorNotIdentical($leftExpr, $rightExpr);
        }
        return null;
    }
    private function refactorIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $leftExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($this->isTrue($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isFalse($rightExpr)) {
            // prevent !!
            if ($leftExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot) {
                return $leftExpr->expr;
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
    private function refactorNotIdentical(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $leftExpr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($this->isFalse($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isTrue($rightExpr)) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
}
