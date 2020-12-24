<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteCodeQuality\Tests\Rector\Identical\SubstrMinusToStringEndsWithRector\SubstrMinusToStringEndsWithRectorTest
 */
final class SubstrMinusToStringEndsWithRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const SUBSTR = 'substr';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change substr function with minus to Strings::endsWith()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
substr($var, -4) !== 'Test';
substr($var, -4) === 'Test';
CODE_SAMPLE
, <<<'CODE_SAMPLE'
! \Nette\Utils\Strings::endsWith($var, 'Test');
\Nette\Utils\Strings::endsWith($var, 'Test');
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
        if (!$this->isFuncCallName($node->left, self::SUBSTR) && !$this->isFuncCallName($node->right, self::SUBSTR)) {
            return null;
        }
        $substr = $this->isFuncCallName($node->left, self::SUBSTR) ? $node->left : $node->right;
        if (!$substr->args[1]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        /** @var UnaryMinus $unaryMinus */
        $unaryMinus = $substr->args[1]->value;
        if (!$unaryMinus->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        $string = $this->isFuncCallName($node->left, self::SUBSTR) ? $node->right : $node->left;
        $wordLength = $unaryMinus->expr->value;
        if ($string instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ && \strlen($string->value) !== $wordLength) {
            return null;
        }
        $staticCall = $this->createStaticCall(\_PhpScopere8e811afab72\Nette\Utils\Strings::class, 'endsWith', [$substr->args[0]->value, $string]);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $staticCall;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($staticCall);
    }
}
