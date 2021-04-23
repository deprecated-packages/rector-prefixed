<?php

declare (strict_types=1);
namespace Rector\NodeNestingScope;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Do_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Switch_;
use PhpParser\Node\Stmt\While_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
final class ContextAnalyzer
{
    /**
     * Nodes that break the scope they way up, e.g. class method
     * @var array<class-string<FunctionLike>>
     */
    private const BREAK_NODES = [\PhpParser\Node\FunctionLike::class, \PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var array<class-string<Stmt>>
     */
    private const LOOP_NODES = [\PhpParser\Node\Stmt\For_::class, \PhpParser\Node\Stmt\Foreach_::class, \PhpParser\Node\Stmt\While_::class, \PhpParser\Node\Stmt\Do_::class, \PhpParser\Node\Stmt\Switch_::class];
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isInLoop(\PhpParser\Node $node) : bool
    {
        $stopNodes = \array_merge(self::LOOP_NODES, self::BREAK_NODES);
        $firstParent = $this->betterNodeFinder->findParentTypes($node, $stopNodes);
        if (!$firstParent instanceof \PhpParser\Node) {
            return \false;
        }
        foreach (self::LOOP_NODES as $type) {
            if (\is_a($firstParent, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
    public function isInIf(\PhpParser\Node $node) : bool
    {
        $breakNodes = \array_merge([\PhpParser\Node\Stmt\If_::class], self::BREAK_NODES);
        $previousNode = $this->betterNodeFinder->findParentTypes($node, $breakNodes);
        if (!$previousNode instanceof \PhpParser\Node) {
            return \false;
        }
        return $previousNode instanceof \PhpParser\Node\Stmt\If_;
    }
}
