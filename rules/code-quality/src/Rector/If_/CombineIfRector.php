<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\If_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Comment\CommentsMerger;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\If_\CombineIfRector\CombineIfRectorTest
 */
final class CombineIfRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CommentsMerger
     */
    private $commentsMerger;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Comment\CommentsMerger $commentsMerger)
    {
        $this->commentsMerger = $commentsMerger;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Merges nested if statements', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if ($cond1) {
            if ($cond2) {
                return 'foo';
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
        if ($cond1 && $cond2) {
            return 'foo';
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_::class];
    }
    /**
     * @param If_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var If_ $subIf */
        $subIf = $node->stmts[0];
        $node->cond = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\BooleanAnd($node->cond, $subIf->cond);
        $node->stmts = $subIf->stmts;
        $this->commentsMerger->keepComments($node, [$subIf]);
        return $node;
    }
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_ $if) : bool
    {
        if ($if->else !== null) {
            return \true;
        }
        if (\count((array) $if->stmts) !== 1) {
            return \true;
        }
        if ($if->elseifs !== []) {
            return \true;
        }
        if (!$if->stmts[0] instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\If_) {
            return \true;
        }
        if ($if->stmts[0]->else !== null) {
            return \true;
        }
        return (bool) $if->stmts[0]->elseifs;
    }
}
