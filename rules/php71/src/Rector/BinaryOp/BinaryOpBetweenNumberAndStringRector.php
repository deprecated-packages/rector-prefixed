<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Rector\BinaryOp;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/XPEEl
 * @see https://3v4l.org/ObNQZ
 * @see \Rector\Php71\Tests\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector\BinaryOpBetweenNumberAndStringRectorTest
 */
final class BinaryOpBetweenNumberAndStringRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change binary operation between some number + string to PHP 7.1 compatible version', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param BinaryOp $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat) {
            return null;
        }
        if ($this->isStringOrStaticNonNumbericString($node->left) && $this->isNumberType($node->right)) {
            $node->left = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        if ($this->isStringOrStaticNonNumbericString($node->right) && $this->isNumberType($node->left)) {
            $node->right = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        return null;
    }
    private function isStringOrStaticNonNumbericString(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        // replace only scalar values, not variables/constants/etc.
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        $value = null;
        $exprStaticType = $this->getStaticType($expr);
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            $value = $expr->value;
        } elseif ($exprStaticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            $value = $exprStaticType->getValue();
        } else {
            return \false;
        }
        return !\is_numeric($value);
    }
}
