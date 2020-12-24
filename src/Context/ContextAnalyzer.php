<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Context;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
final class ContextAnalyzer
{
    /**
     * Nodes that break the scope they way up, e.g. class method
     * @var string[]
     */
    private const BREAK_NODES = [\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    /**
     * @var string[]
     */
    private const LOOP_NODES = [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\For_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Foreach_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\While_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Do_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Switch_::class];
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder)
    {
        $this->betterNodeFinder = $betterNodeFinder;
    }
    public function isInLoop(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $stopNodes = \array_merge(self::LOOP_NODES, self::BREAK_NODES);
        $firstParent = $this->betterNodeFinder->findFirstParentInstanceOf($node, $stopNodes);
        if ($firstParent === null) {
            return \false;
        }
        return $this->isTypes($firstParent, self::LOOP_NODES);
    }
    public function isInIf(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        $breakNodes = \array_merge([\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class], self::BREAK_NODES);
        $previousNode = $this->betterNodeFinder->findFirstParentInstanceOf($node, $breakNodes);
        if ($previousNode === null) {
            return \false;
        }
        return $this->isTypes($previousNode, [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\If_::class]);
    }
    /**
     * @param string[] $types
     */
    private function isTypes(\_PhpScoperb75b35f52b74\PhpParser\Node $node, array $types) : bool
    {
        foreach ($types as $type) {
            if (\is_a($node, $type, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
