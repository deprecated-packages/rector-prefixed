<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Rector\Identical;

use RectorPrefix20210308\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\UnaryMinus;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use Rector\NetteCodeQuality\NodeAnalyzer\BinaryOpAnalyzer;
use Rector\NetteCodeQuality\ValueObject\FuncCallAndExpr;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteCodeQuality\Tests\Rector\Identical\SubstrMinusToStringEndsWithRector\SubstrMinusToStringEndsWithRectorTest
 */
final class SubstrMinusToStringEndsWithRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const SUBSTR = 'substr';
    /**
     * @var BinaryOpAnalyzer
     */
    private $binaryOpAnalyzer;
    public function __construct(\Rector\NetteCodeQuality\NodeAnalyzer\BinaryOpAnalyzer $binaryOpAnalyzer)
    {
        $this->binaryOpAnalyzer = $binaryOpAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change substr function with minus to Strings::endsWith()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\Identical::class, \PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $funcCallAndExpr = $this->binaryOpAnalyzer->matchFuncCallAndOtherExpr($node, self::SUBSTR);
        if (!$funcCallAndExpr instanceof \Rector\NetteCodeQuality\ValueObject\FuncCallAndExpr) {
            return null;
        }
        $substrFuncCall = $funcCallAndExpr->getFuncCall();
        if (!$substrFuncCall->args[1]->value instanceof \PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        /** @var UnaryMinus $unaryMinus */
        $unaryMinus = $substrFuncCall->args[1]->value;
        if (!$unaryMinus->expr instanceof \PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        $string = $funcCallAndExpr->getExpr();
        $wordLength = $unaryMinus->expr->value;
        if ($string instanceof \PhpParser\Node\Scalar\String_ && \strlen($string->value) !== $wordLength) {
            return null;
        }
        $arguments = [$substrFuncCall->args[0]->value, $string];
        $staticCall = $this->nodeFactory->createStaticCall(\RectorPrefix20210308\Nette\Utils\Strings::class, 'endsWith', $arguments);
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\Identical) {
            return $staticCall;
        }
        return new \PhpParser\Node\Expr\BooleanNot($staticCall);
    }
}
