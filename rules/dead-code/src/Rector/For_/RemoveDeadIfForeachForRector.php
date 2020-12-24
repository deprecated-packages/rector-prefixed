<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\For_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\For_\RemoveDeadIfForeachForRector\RemoveDeadIfForeachForRectorTest
 */
final class RemoveDeadIfForeachForRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove if, foreach and for that does not do anything', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
, <<<'CODE_SAMPLE'
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
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param For_|If_|Foreach_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_) {
            $this->processIf($node);
            return null;
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_) {
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
    private function processIf(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_ $if) : void
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
    private function processForeach(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        if ($foreach->stmts !== []) {
            return;
        }
        if ($this->isNodeWithSideEffect($foreach->expr)) {
            return;
        }
        $this->removeNode($foreach);
    }
    private function isNodeWithSideEffect(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar) {
            return \false;
        }
        return !$this->isBool($expr);
    }
}
