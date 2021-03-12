<?php

declare (strict_types=1);
namespace Rector\Php54\Rector\Break_;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Continue_;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\ConstantType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/control-structures.continue.php
 * @see https://www.php.net/manual/en/control-structures.break.php
 *
 * @see \Rector\Tests\Php54\Rector\Break_\RemoveZeroBreakContinueRector\RemoveZeroBreakContinueRectorTest
 */
final class RemoveZeroBreakContinueRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove 0 from break and continue', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Break_::class, \PhpParser\Node\Stmt\Continue_::class];
    }
    /**
     * @param Break_|Continue_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->num === null) {
            return null;
        }
        if ($node->num instanceof \PhpParser\Node\Scalar\LNumber) {
            $number = $this->valueResolver->getValue($node->num);
            if ($number > 1) {
                return null;
            }
            if ($number === 0) {
                $node->num = null;
                return $node;
            }
            return null;
        }
        if ($node->num instanceof \PhpParser\Node\Expr\Variable) {
            return $this->processVariableNum($node, $node->num);
        }
        return null;
    }
    /**
     * @param Break_|Continue_ $stmt
     */
    private function processVariableNum(\PhpParser\Node\Stmt $stmt, \PhpParser\Node\Expr\Variable $numVariable) : ?\PhpParser\Node
    {
        $staticType = $this->getStaticType($numVariable);
        if ($staticType instanceof \PHPStan\Type\ConstantType) {
            if ($staticType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                if ($staticType->getValue() === 0) {
                    $stmt->num = null;
                    return $stmt;
                }
                if ($staticType->getValue() > 0) {
                    $stmt->num = new \PhpParser\Node\Scalar\LNumber($staticType->getValue());
                    return $stmt;
                }
            }
            return $stmt;
        }
        // remove variable
        $stmt->num = null;
        return null;
    }
}
