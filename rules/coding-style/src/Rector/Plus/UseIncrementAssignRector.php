<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\Plus;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Minus;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Plus;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Plus\UseIncrementAssignRector\UseIncrementAssignRectorTest
 */
final class UseIncrementAssignRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++ increment instead of `$var += 1`', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $style += 1;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        ++$style;
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Plus::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Minus::class];
    }
    /**
     * @param Plus|Minus $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        if ($node->expr->value !== 1) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\AssignOp\Plus) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec($node->var);
    }
}
