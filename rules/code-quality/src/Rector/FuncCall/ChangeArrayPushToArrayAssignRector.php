<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/559844/whats-better-to-use-in-php-array-value-or-array-pusharray-value
 *
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\ChangeArrayPushToArrayAssignRector\ChangeArrayPushToArrayAssignRectorTest
 */
final class ChangeArrayPushToArrayAssignRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array_push() to direct variable assign', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];
        array_push($items, $item);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $items = [];
        $items[] = $item;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'array_push')) {
            return null;
        }
        if ($this->hasArraySpread($node)) {
            return null;
        }
        $arrayDimFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch($node->args[0]->value);
        $position = 1;
        while (isset($node->args[$position])) {
            $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($arrayDimFetch, $node->args[$position]->value);
            $assignExpression = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
            // keep comments of first line
            if ($position === 1) {
                $this->mirrorComments($assignExpression, $node);
            }
            $this->addNodeAfterNode($assignExpression, $node);
            ++$position;
        }
        $this->removeNode($node);
        return null;
    }
    private function hasArraySpread(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        foreach ($funcCall->args as $arg) {
            /** @var Arg $arg */
            if ($arg->unpack) {
                return \true;
            }
        }
        return \false;
    }
}
