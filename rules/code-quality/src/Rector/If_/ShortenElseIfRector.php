<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\ShortenElseIfRector\ShortenElseIfRectorTest
 */
final class ShortenElseIfRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Shortens else/if to elseif', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->shortenElseIf($node);
    }
    private function shortenElseIf(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_
    {
        if ($node->else === null) {
            return null;
        }
        $else = $node->else;
        if (\count((array) $else->stmts) !== 1) {
            return null;
        }
        $if = $else->stmts[0];
        if (!$if instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_) {
            return null;
        }
        // Try to shorten the nested if before transforming it to elseif
        $refactored = $this->shortenElseIf($if);
        if ($refactored !== null) {
            $if = $refactored;
        }
        $node->elseifs[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_($if->cond, $if->stmts);
        $node->else = $if->else;
        $node->elseifs = \array_merge($node->elseifs, $if->elseifs);
        return $node;
    }
}
