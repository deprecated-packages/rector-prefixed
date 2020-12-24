<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Context;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Do_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\For_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\While_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
final class ContextAnalyzer
{
    /**
     * Nodes that break the scope they way up, e.g. class method
     * @var string[]
     */
    private const BREAK_NODES = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var string[]
     */
    private const LOOP_NODES = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\For_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\While_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Do_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Switch_::class];
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isInLoop(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $stopNodes = \array_merge(self::LOOP_NODES, self::BREAK_NODES);
        $firstParent = $this->betterNodeFinder->findFirstParentInstanceOf($node, $stopNodes);
        if ($firstParent === null) {
            return \false;
        }
        return $this->isTypes($firstParent, self::LOOP_NODES);
    }
    public function isInIf(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $breakNodes = \array_merge([\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_::class], self::BREAK_NODES);
        $previousNode = $this->betterNodeFinder->findFirstParentInstanceOf($node, $breakNodes);
        if ($previousNode === null) {
            return \false;
        }
        return $this->isTypes($previousNode, [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\If_::class]);
    }
    /**
     * @param string[] $types
     */
    private function isTypes(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($node, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
