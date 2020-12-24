<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.reddit.com/r/PHP/comments/aqk01p/is_there_a_situation_in_which_if_countarray_0/
 * @see https://3v4l.org/UCd1b
 * @see \Rector\CodeQuality\Tests\Rector\If_\ExplicitBoolCompareRector\ExplicitBoolCompareRectorTest
 */
final class ExplicitBoolCompareRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make if conditions more explicit', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ElseIf_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param If_|ElseIf_|Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        // skip short ternary
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary && $node->if === null) {
            return null;
        }
        if ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BooleanNot) {
            $conditionNode = $node->cond->expr;
            $isNegated = \true;
        } else {
            $conditionNode = $node->cond;
            $isNegated = \false;
        }
        if ($conditionNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Bool_) {
            return null;
        }
        $conditionStaticType = $this->getStaticType($conditionNode);
        if ($conditionStaticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType) {
            return null;
        }
        $newConditionNode = $this->resolveNewConditionNode($conditionNode, $isNegated);
        if ($newConditionNode === null) {
            return null;
        }
        $node->cond = $newConditionNode;
        return $node;
    }
    private function resolveNewConditionNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr, bool $isNegated) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        // various cases
        if ($this->isFuncCallName($expr, 'count')) {
            return $this->resolveCount($isNegated, $expr);
        }
        if ($this->isArrayType($expr)) {
            return $this->resolveArray($isNegated, $expr);
        }
        if ($this->isStringOrUnionStringOnlyType($expr)) {
            return $this->resolveString($isNegated, $expr);
        }
        if ($this->isStaticType($expr, \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType::class)) {
            return $this->resolveInteger($isNegated, $expr);
        }
        if ($this->isStaticType($expr, \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType::class)) {
            return $this->resolveFloat($isNegated, $expr);
        }
        if ($this->isNullableObjectType($expr)) {
            return $this->resolveNullable($isNegated, $expr);
        }
        return null;
    }
    /**
     * @return Identical|Greater
     */
    private function resolveCount(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $lNumber = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber(0);
        // compare === 0, assumption
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $lNumber);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater($expr, $lNumber);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveArray(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $array = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_([]);
        // compare === []
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $array);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $array);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveString(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $string = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_('');
        // compare === ''
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $string);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $string);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveInteger(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $lNumber = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber(0);
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $lNumber);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $lNumber);
    }
    private function resolveFloat(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $dNumber = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\DNumber(0.0);
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $dNumber);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $dNumber);
    }
    /**
     * @return Identical|NotIdentical
     */
    private function resolveNullable(bool $isNegated, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp
    {
        $constFetch = $this->createNull();
        if ($isNegated) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical($expr, $constFetch);
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $constFetch);
    }
}
