<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\If_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\If_\NullableCompareToNullRector\NullableCompareToNullRectorTest
 */
final class NullableCompareToNullRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes negate of empty comparison of nullable value to explicit === or !== compare', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
/** @var stdClass|null $value */
if ($value) {
}

if (!$value) {
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
/** @var stdClass|null $value */
if ($value !== null) {
}

if ($value === null) {
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node->cond instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot && $this->isNullableNonScalarType($node->cond->expr)) {
            $node->cond = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical($node->cond->expr, $this->createNull());
            return $node;
        }
        if ($this->isNullableNonScalarType($node->cond)) {
            $node->cond = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->cond, $this->createNull());
            return $node;
        }
        return null;
    }
    private function isNullableNonScalarType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $staticType = $this->getStaticType($node);
        if ($staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return \false;
        }
        if (!$staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return \false;
        }
        // is non-nullable?
        if ($staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType())->no()) {
            return \false;
        }
        // is array?
        foreach ($staticType->getTypes() as $subType) {
            if ($subType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                return \false;
            }
        }
        // is string?
        if ($staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType())->yes()) {
            return \false;
        }
        // is number?
        if ($staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType())->yes()) {
            return \false;
        }
        // is bool?
        if ($staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType())->yes()) {
            return \false;
        }
        return !$staticType->isSuperTypeOf(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType())->yes();
    }
}
