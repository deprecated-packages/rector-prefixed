<?php

declare(strict_types=1);

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

    public function __construct(BetterNodeFinder $betterNodeFinder, ScopeNestingComparator $scopeNestingComparator)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->scopeNestingComparator = $scopeNestingComparator;
    }

    /**
     * @return \PhpParser\Node\Stmt\Return_|null
     */
    public function findLastClassMethodReturn(ClassMethod $classMethod)
    {
        /** @var Return_[] $returns */
        $returns = $this->betterNodeFinder->findInstanceOf($classMethod, Return_::class);

        // put the latest first
        $returns = array_reverse($returns);

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
    public function isBeforeLastReturn(Assign $assign, $lastReturn): bool
    {
        if (! $lastReturn instanceof Return_) {
            return true;
        }

        return $lastReturn->getStartTokenPos() < $assign->getStartTokenPos();
    }
}
