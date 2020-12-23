<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait CallableNodeTraverserTrait
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @required
     */
    public function autowireCallableNodeTraverserTrait(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser) : void
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Node|Node[] $nodes
     */
    public function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($nodes, $callable);
    }
}
