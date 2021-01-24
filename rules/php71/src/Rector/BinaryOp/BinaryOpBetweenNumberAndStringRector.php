<?php

declare (strict_types=1);
namespace Rector\Php71\Rector\BinaryOp;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PHPStan\Type\Constant\ConstantStringType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/XPEEl
 * @see https://3v4l.org/ObNQZ
 * @see \Rector\Php71\Tests\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector\BinaryOpBetweenNumberAndStringRectorTest
 */
final class BinaryOpBetweenNumberAndStringRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change binary operation between some number + string to PHP 7.1 compatible version', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 5 + '';
        $value = 5.0 + 'hi';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 5 + 0;
        $value = 5.0 + 0
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
        return [\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param BinaryOp $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            return null;
        }
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Coalesce) {
            return null;
        }
        if ($this->isStringOrStaticNonNumbericString($node->left) && $this->isNumberType($node->right)) {
            $node->left = new \PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        if ($this->isStringOrStaticNonNumbericString($node->right) && $this->isNumberType($node->left)) {
            $node->right = new \PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        return null;
    }
    private function isStringOrStaticNonNumbericString(\PhpParser\Node\Expr $expr) : bool
    {
        // replace only scalar values, not variables/constants/etc.
        if (!$expr instanceof \PhpParser\Node\Scalar && !$expr instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        $value = null;
        $exprStaticType = $this->getStaticType($expr);
        if ($expr instanceof \PhpParser\Node\Scalar\String_) {
            $value = $expr->value;
        } elseif ($exprStaticType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $value = $exprStaticType->getValue();
        } else {
            return \false;
        }
        return !\is_numeric($value);
    }
}
