<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\Rector\Identical;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteCodeQuality\Tests\Rector\Identical\SubstrMinusToStringEndsWithRector\SubstrMinusToStringEndsWithRectorTest
 */
final class SubstrMinusToStringEndsWithRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const SUBSTR = 'substr';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change substr function with minus to Strings::endsWith()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isFuncCallName($node->left, self::SUBSTR) && !$this->isFuncCallName($node->right, self::SUBSTR)) {
            return null;
        }
        $substr = $this->isFuncCallName($node->left, self::SUBSTR) ? $node->left : $node->right;
        if (!$substr->args[1]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        /** @var UnaryMinus $unaryMinus */
        $unaryMinus = $substr->args[1]->value;
        if (!$unaryMinus->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        $string = $this->isFuncCallName($node->left, self::SUBSTR) ? $node->right : $node->left;
        $wordLength = $unaryMinus->expr->value;
        if ($string instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_ && \strlen($string->value) !== $wordLength) {
            return null;
        }
        $staticCall = $this->createStaticCall(\_PhpScoper0a6b37af0871\Nette\Utils\Strings::class, 'endsWith', [$substr->args[0]->value, $string]);
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $staticCall;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot($staticCall);
    }
}
