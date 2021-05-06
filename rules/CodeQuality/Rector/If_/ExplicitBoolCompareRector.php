<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\If_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\If_;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @changelog https://www.reddit.com/r/PHP/comments/aqk01p/is_there_a_situation_in_which_if_countarray_0/
 * @see https://3v4l.org/UCd1b
 *
 * @see \Rector\Tests\CodeQuality\Rector\If_\ExplicitBoolCompareRector\ExplicitBoolCompareRectorTest
 */
final class ExplicitBoolCompareRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var \Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer
     */
    private $stringTypeAnalyzer;
    /**
     * @var \Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    public function __construct(\Rector\NodeTypeResolver\TypeAnalyzer\StringTypeAnalyzer $stringTypeAnalyzer, \Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer)
    {
        $this->stringTypeAnalyzer = $stringTypeAnalyzer;
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make if conditions more explicit', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeController
{
    public function run($items)
    {
        if (!count($items)) {
            return 'no items';
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeController
{
    public function run($items)
    {
        if (count($items) === 0) {
            return 'no items';
        }
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\If_::class, \PhpParser\Node\Stmt\ElseIf_::class, \PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param If_|ElseIf_|Ternary $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        // skip short ternary
        if ($node instanceof \PhpParser\Node\Expr\Ternary && $node->if === null) {
            return null;
        }
        if ($node->cond instanceof \PhpParser\Node\Expr\BooleanNot) {
            $conditionNode = $node->cond->expr;
            $isNegated = \true;
        } else {
            $conditionNode = $node->cond;
            $isNegated = \false;
        }
        if ($conditionNode instanceof \PhpParser\Node\Expr\Cast\Bool_) {
            return null;
        }
        $conditionStaticType = $this->getStaticType($conditionNode);
        if ($conditionStaticType instanceof \PHPStan\Type\BooleanType) {
            return null;
        }
        $newConditionNode = $this->resolveNewConditionNode($conditionNode, $isNegated);
        if (!$newConditionNode instanceof \PhpParser\Node\Expr\BinaryOp) {
            return null;
        }
        $node->cond = $newConditionNode;
        return $node;
    }
    private function resolveNewConditionNode(\PhpParser\Node\Expr $expr, bool $isNegated) : ?\PhpParser\Node\Expr\BinaryOp
    {
        if ($expr instanceof \PhpParser\Node\Expr\FuncCall && $this->nodeNameResolver->isName($expr, 'count')) {
            return $this->resolveCount($isNegated, $expr);
        }
        if ($this->arrayTypeAnalyzer->isArrayType($expr)) {
            return $this->resolveArray($isNegated, $expr);
        }
        if ($this->stringTypeAnalyzer->isStringOrUnionStringOnlyType($expr)) {
            return $this->resolveString($isNegated, $expr);
        }
        if ($this->nodeTypeResolver->isStaticType($expr, \PHPStan\Type\IntegerType::class)) {
            return $this->resolveInteger($isNegated, $expr);
        }
        if ($this->nodeTypeResolver->isStaticType($expr, \PHPStan\Type\FloatType::class)) {
            return $this->resolveFloat($isNegated, $expr);
        }
        if ($this->nodeTypeResolver->isNullableTypeOfSpecificType($expr, \PHPStan\Type\ObjectType::class)) {
            return $this->resolveNullable($isNegated, $expr);
        }
        return null;
    }
    /**
     * @return Identical|Greater
     */
    private function resolveCount(bool $isNegated, \PhpParser\Node\Expr\FuncCall $funcCall) : \PhpParser\Node\Expr\BinaryOp
    {
        $lNumber = new \PhpParser\Node\Scalar\LNumber(0);
        // compare === 0, assumption
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($funcCall, $lNumber);
        }
        return new \PhpParser\Node\Expr\BinaryOp\Greater($funcCall, $lNumber);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveArray(bool $isNegated, \PhpParser\Node\Expr $expr) : ?\PhpParser\Node\Expr\BinaryOp
    {
        if (!$expr instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        $array = new \PhpParser\Node\Expr\Array_([]);
        // compare === []
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($expr, $array);
        }
        return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $array);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveString(bool $isNegated, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\BinaryOp
    {
        $string = new \PhpParser\Node\Scalar\String_('');
        // compare === ''
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($expr, $string);
        }
        return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $string);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveInteger(bool $isNegated, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\BinaryOp
    {
        $lNumber = new \PhpParser\Node\Scalar\LNumber(0);
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($expr, $lNumber);
        }
        return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $lNumber);
    }
    private function resolveFloat(bool $isNegated, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\BinaryOp
    {
        $dNumber = new \PhpParser\Node\Scalar\DNumber(0.0);
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($expr, $dNumber);
        }
        return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $dNumber);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveNullable(bool $isNegated, \PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\BinaryOp
    {
        $constFetch = $this->nodeFactory->createNull();
        if ($isNegated) {
            return new \PhpParser\Node\Expr\BinaryOp\Identical($expr, $constFetch);
        }
        return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $constFetch);
    }
}
