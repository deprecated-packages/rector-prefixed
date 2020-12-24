<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php54\Rector\Break_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/control-structures.continue.php
 * @see https://www.php.net/manual/en/control-structures.break.php
 *
 * @see \Rector\Php54\Tests\Rector\Break_\RemoveZeroBreakContinueRector\RemoveZeroBreakContinueRectorTest
 */
final class RemoveZeroBreakContinueRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove 0 from break and continue', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($random)
    {
        continue 0;
        break 0;

        $five = 5;
        continue $five;

        break $random;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($random)
    {
        continue;
        break;

        $five = 5;
        continue 5;

        break;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Break_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Continue_::class];
    }
    /**
     * @param Break_|Continue_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->num === null) {
            return null;
        }
        if ($node->num instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
            $number = $this->getValue($node->num);
            if ($number > 1) {
                return null;
            }
            if ($number === 0) {
                $node->num = null;
                return $node;
            }
            return null;
        }
        if ($node->num instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return $this->processVariableNum($node, $node->num);
        }
        return null;
    }
    /**
     * @param Break_|Continue_ $node
     */
    private function processVariableNum(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $numVariable) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $staticType = $this->getStaticType($numVariable);
        if ($staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ConstantType) {
            if ($staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($staticType->getValue() === 0) {
                    $node->num = null;
                    return $node;
                }
                if ($staticType->getValue() > 0) {
                    $node->num = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber($staticType->getValue());
                    return $node;
                }
            }
            return $node;
        }
        // remove variable
        $node->num = null;
        return null;
    }
}
