<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/559844/whats-better-to-use-in-php-array-value-or-array-pusharray-value
 *
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\ChangeArrayPushToArrayAssignRector\ChangeArrayPushToArrayAssignRectorTest
 */
final class ChangeArrayPushToArrayAssignRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array_push() to direct variable assign', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, 'array_push')) {
            return null;
        }
        if ($this->hasArraySpread($node)) {
            return null;
        }
        $arrayDimFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($node->args[0]->value);
        $position = 1;
        while (isset($node->args[$position])) {
            $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($arrayDimFetch, $node->args[$position]->value);
            $assignExpression = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
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
    private function hasArraySpread(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall) : bool
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
