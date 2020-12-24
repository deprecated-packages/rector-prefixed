<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\If_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\ShortenElseIfRector\ShortenElseIfRectorTest
 */
final class ShortenElseIfRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Shortens else/if to elseif', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($cond1) {
            return $action1;
        } else {
            if ($cond2) {
                return $action2;
            }
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($cond1) {
            return $action1;
        } elseif ($cond2) {
            return $action2;
        }
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->shortenElseIf($node);
    }
    private function shortenElseIf(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_
    {
        if ($node->else === null) {
            return null;
        }
        $else = $node->else;
        if (\count((array) $else->stmts) !== 1) {
            return null;
        }
        $if = $else->stmts[0];
        if (!$if instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            return null;
        }
        // Try to shorten the nested if before transforming it to elseif
        $refactored = $this->shortenElseIf($if);
        if ($refactored !== null) {
            $if = $refactored;
        }
        $node->elseifs[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ElseIf_($if->cond, $if->stmts);
        $node->else = $if->else;
        $node->elseifs = \array_merge($node->elseifs, $if->elseifs);
        return $node;
    }
}
