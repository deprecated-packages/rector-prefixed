<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\If_\NullableCompareToNullRector\NullableCompareToNullRectorTest
 */
final class NullableCompareToNullRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes negate of empty comparison of nullable value to explicit === or !== compare', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node->cond instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot && $this->isNullableNonScalarType($node->cond->expr)) {
            $node->cond = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical($node->cond->expr, $this->createNull());
            return $node;
        }
        if ($this->isNullableNonScalarType($node->cond)) {
            $node->cond = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical($node->cond, $this->createNull());
            return $node;
        }
        return null;
    }
    private function isNullableNonScalarType(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        $staticType = $this->getStaticType($node);
        if ($staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \false;
        }
        if (!$staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return \false;
        }
        // is non-nullable?
        if ($staticType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType())->no()) {
            return \false;
        }
        // is array?
        foreach ($staticType->getTypes() as $subType) {
            if ($subType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                return \false;
            }
        }
        // is string?
        if ($staticType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())->yes()) {
            return \false;
        }
        // is number?
        if ($staticType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType())->yes()) {
            return \false;
        }
        // is bool?
        if ($staticType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType())->yes()) {
            return \false;
        }
        return !$staticType->isSuperTypeOf(new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType())->yes();
    }
}
