<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeFinder;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function find(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $currentAssign = $assign;
        $variableName = $this->nodeNameResolver->getName($assign->var);
        $assign = $this->betterNodeFinder->findFirstPrevious($assign, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($variableName, $currentAssign) : bool {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
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
