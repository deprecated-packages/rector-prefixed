<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/GoEPq
 * @see \Rector\CodeQuality\Tests\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector\BooleanNotIdenticalToNotIdenticalRectorTest
 */
final class BooleanNotIdenticalToNotIdenticalRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Negated identical boolean compare to not identical compare (does not apply to non-bool values)', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = true;
        $b = false;

        var_dump(! $a === $b); // true
        var_dump(! ($a === $b)); // true
        var_dump($a !== $b); // true
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = true;
        $b = false;

        var_dump($a !== $b); // true
        var_dump($a !== $b); // true
        var_dump($a !== $b); // true
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot::class];
    }
    /**
     * @param Identical|BooleanNot $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            return $this->processIdentical($node);
        }
        if ($node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical) {
            $identical = $node->expr;
            if (!$this->isStaticType($identical->left, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
                return null;
            }
            if (!$this->isStaticType($identical->right, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($identical->left, $identical->right);
        }
        return null;
    }
    private function processIdentical(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical
    {
        if (!$this->isStaticType($identical->left, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
            return null;
        }
        if (!$this->isStaticType($identical->right, \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class)) {
            return null;
        }
        if ($identical->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($identical->left->expr, $identical->right);
        }
        return null;
    }
}
