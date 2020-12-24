<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\NodeFinder;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class PreviousVariableAssignNodeFinder
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function find(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $currentAssign = $assign;
        $variableName = $this->nodeNameResolver->getName($assign->var);
        $assign = $this->betterNodeFinder->findFirstPrevious($assign, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($variableName, $currentAssign) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            // skil self
            if ($node === $currentAssign) {
                return \false;
            }
            return $this->nodeNameResolver->isName($node->var, $variableName);
        });
        /** @var Assign|null $assign */
        return $assign;
    }
}
