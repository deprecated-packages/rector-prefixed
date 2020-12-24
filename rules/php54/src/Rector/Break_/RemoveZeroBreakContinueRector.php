<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php54\Rector\Break_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Break_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantType;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.php.net/manual/en/control-structures.continue.php
 * @see https://www.php.net/manual/en/control-structures.break.php
 *
 * @see \Rector\Php54\Tests\Rector\Break_\RemoveZeroBreakContinueRector\RemoveZeroBreakContinueRectorTest
 */
final class RemoveZeroBreakContinueRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove 0 from break and continue', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Break_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Continue_::class];
    }
    /**
     * @param Break_|Continue_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->num === null) {
            return null;
        }
        if ($node->num instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber) {
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
        if ($node->num instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
            return $this->processVariableNum($node, $node->num);
        }
        return null;
    }
    /**
     * @param Break_|Continue_ $node
     */
    private function processVariableNum(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $numVariable) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $staticType = $this->getStaticType($numVariable);
        if ($staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType) {
            if ($staticType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                if ($staticType->getValue() === 0) {
                    $node->num = null;
                    return $node;
                }
                if ($staticType->getValue() > 0) {
                    $node->num = new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber($staticType->getValue());
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
