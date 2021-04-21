<?php

declare(strict_types=1);

namespace Rector\DeadCode\Rector\For_;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\DeadCode\Rector\For_\RemoveDeadIfForeachForRector\RemoveDeadIfForeachForRectorTest
 */
final class RemoveDeadIfForeachForRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove if, foreach and for that does not do anything',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($someObject)
    {
        $value = 5;
        if ($value) {
        }

        if ($someObject->run()) {
        }

        foreach ($values as $value) {
        }

        return $value;
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($someObject)
    {
        $value = 5;
        if ($someObject->run()) {
        }

        return $value;
    }
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [For_::class, If_::class, Foreach_::class];
    }

    /**
     * @param For_|If_|Foreach_ $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof If_) {
            $this->processIf($node);
            return null;
        }

        if ($node instanceof Foreach_) {
            $this->processForeach($node);
            return null;
        }

        // For
        if ($node->stmts !== []) {
            return null;
        }

        $this->removeNode($node);

        return null;
    }

    /**
     * @return void
     */
    private function processIf(If_ $if)
    {
        if ($if->stmts !== []) {
            return;
        }

        if ($if->else !== null) {
            return;
        }

        if ($if->elseifs !== []) {
            return;
        }

        if ($this->isNodeWithSideEffect($if->cond)) {
            return;
        }

        $this->removeNode($if);
    }

    /**
     * @return void
     */
    private function processForeach(Foreach_ $foreach)
    {
        if ($foreach->stmts !== []) {
            return;
        }

        if ($this->isNodeWithSideEffect($foreach->expr)) {
            return;
        }

        $this->removeNode($foreach);
    }

    private function isNodeWithSideEffect(Expr $expr): bool
    {
        if ($expr instanceof Variable) {
            return false;
        }

        if ($expr instanceof Scalar) {
            return false;
        }
        return ! $this->valueResolver->isTrueOrFalse($expr);
    }
}
