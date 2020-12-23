<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\TryCatch;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Catch_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TryCatch;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\TryCatch\RemoveDeadTryCatchRector\RemoveDeadTryCatchRectorTest
 */
final class RemoveDeadTryCatchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove dead try/catch', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        try {
            // some code
        }
        catch (Throwable $throwable) {
            throw $throwable;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        // some code
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TryCatch::class];
    }
    /**
     * @param TryCatch $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (\count((array) $node->catches) !== 1) {
            return null;
        }
        /** @var Catch_ $onlyCatch */
        $onlyCatch = $node->catches[0];
        if (\count((array) $onlyCatch->stmts) !== 1) {
            return null;
        }
        if ($node->finally !== null && $node->finally->stmts !== []) {
            return null;
        }
        $onlyCatchStmt = $onlyCatch->stmts[0];
        if (!$onlyCatchStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Throw_) {
            return null;
        }
        if (!$this->areNodesEqual($onlyCatch->var, $onlyCatchStmt->expr)) {
            return null;
        }
        $this->addNodesAfterNode((array) $node->stmts, $node);
        $this->removeNode($node);
        return null;
    }
}
