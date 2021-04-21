<?php

declare (strict_types=1);
namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\NodeNestingScope\ScopeNestingComparator;
final class ReturnAnalyzer
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->scopeNestingComparator = $scopeNestingComparator;
    }
    /**
     * @return \PhpParser\Node\Stmt\Return_|null
     */
    public function findLastClassMethodReturn(\PhpParser\Node\Stmt\ClassMethod $classMethod)
    {
        /** @var Return_[] $returns */
        $returns = $this->betterNodeFinder->findInstanceOf($classMethod, \PhpParser\Node\Stmt\Return_::class);
        // put the latest first
        $returns = \array_reverse($returns);
        foreach ($returns as $return) {
            if ($this->scopeNestingComparator->areReturnScopeNested($return, $classMethod)) {
                return $return;
            }
        }
        return null;
    }
    /**
     * @param \PhpParser\Node\Stmt\Return_|null $lastReturn
     */
    public function isBeforeLastReturn(\PhpParser\Node\Expr\Assign $assign, $lastReturn) : bool
    {
        if (!$lastReturn instanceof \PhpParser\Node\Stmt\Return_) {
            return \true;
        }
        return $lastReturn->getStartTokenPos() < $assign->getStartTokenPos();
    }
}
