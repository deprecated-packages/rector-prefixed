<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\EarlyReturn\Rector\If_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Exit_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ElseIf_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\EarlyReturn\Tests\Rector\If_\RemoveAlwaysElseRector\RemoveAlwaysElseRectorTest
 */
final class RemoveAlwaysElseRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Split if statement, when if condition always break execution flow', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        if ($value) {
            throw new \InvalidStateException;
        } else {
            return 10;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        if ($value) {
            throw new \InvalidStateException;
        }

        return 10;
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
        if ($this->doesLastStatementBreakFlow($node)) {
            return null;
        }
        if ($node->elseifs !== []) {
            $if = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_($node->cond);
            $if->stmts = $node->stmts;
            $this->addNodeBeforeNode($if, $node);
            /** @var ElseIf_ $firstElseIf */
            $firstElseIf = \array_shift($node->elseifs);
            $node->cond = $firstElseIf->cond;
            $node->stmts = $firstElseIf->stmts;
            $this->mirrorComments($node, $firstElseIf);
            return $node;
        }
        if ($node->else !== null) {
            $this->addNodesAfterNode((array) $node->else->stmts, $node);
            $node->else = null;
            return $node;
        }
        return null;
    }
    private function doesLastStatementBreakFlow(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\If_ $if) : bool
    {
        $lastStmt = \end($if->stmts);
        return !($lastStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ || $lastStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_ || $lastStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Continue_ || $lastStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression && $lastStmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Exit_);
    }
}
