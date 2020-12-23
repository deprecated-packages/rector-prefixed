<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\Identical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\SimplifyBoolIdenticalTrueRector\SimplifyBoolIdenticalTrueRectorTest
 */
final class SimplifyBoolIdenticalTrueRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Symplify bool value compare to true or false', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->isStaticType($node->left, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class) && !$this->isBool($node->left)) {
            return $this->processBoolTypeToNotBool($node, $node->left, $node->right);
        }
        if ($this->isStaticType($node->right, \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType::class) && !$this->isBool($node->right)) {
            return $this->processBoolTypeToNotBool($node, $node->right, $node->left);
        }
        return null;
    }
    private function processBoolTypeToNotBool(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $leftExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->refactorIdentical($leftExpr, $rightExpr);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return $this->refactorNotIdentical($leftExpr, $rightExpr);
        }
        return null;
    }
    private function refactorIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $leftExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($this->isTrue($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isFalse($rightExpr)) {
            // prevent !!
            if ($leftExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot) {
                return $leftExpr->expr;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
    private function refactorNotIdentical(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $leftExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $rightExpr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        if ($this->isFalse($rightExpr)) {
            return $leftExpr;
        }
        if ($this->isTrue($rightExpr)) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($leftExpr);
        }
        return null;
    }
}
