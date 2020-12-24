<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\Plus;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Plus\UseIncrementAssignRector\UseIncrementAssignRectorTest
 */
final class UseIncrementAssignRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use ++ increment instead of `$var += 1`', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Minus::class];
    }
    /**
     * @param Plus|Minus $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber) {
            return null;
        }
        if ($node->expr->value !== 1) {
            return null;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Plus) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc($node->var);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec($node->var);
    }
}
