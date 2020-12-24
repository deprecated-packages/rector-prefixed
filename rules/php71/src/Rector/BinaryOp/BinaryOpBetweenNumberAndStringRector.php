<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\Rector\BinaryOp;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/XPEEl
 * @see https://3v4l.org/ObNQZ
 * @see \Rector\Php71\Tests\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector\BinaryOpBetweenNumberAndStringRectorTest
 */
final class BinaryOpBetweenNumberAndStringRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change binary operation between some number + string to PHP 7.1 compatible version', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp::class];
    }
    /**
     * @param BinaryOp $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
            return null;
        }
        if ($this->isStringOrStaticNonNumbericString($node->left) && $this->isNumberType($node->right)) {
            $node->left = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        if ($this->isStringOrStaticNonNumbericString($node->right) && $this->isNumberType($node->left)) {
            $node->right = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            return $node;
        }
        return null;
    }
    private function isStringOrStaticNonNumbericString(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        // replace only scalar values, not variables/constants/etc.
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar && !$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        $value = null;
        $exprStaticType = $this->getStaticType($expr);
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            $value = $expr->value;
        } elseif ($exprStaticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            $value = $exprStaticType->getValue();
        } else {
            return \false;
        }
        return !\is_numeric($value);
    }
}
