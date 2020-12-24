<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PhpParser\NodeVisitor;
use _PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract;
final class CallableNodeTraverser
{
    /**
     * @param Node|Node[]|null $nodes
     */
    public function traverseNodesWithCallable($nodes, callable $callable) : void
    {
        if ($nodes === [] || $nodes === null) {
            return;
        }
        if (!\is_array($nodes)) {
            $nodes = [$nodes];
        }
        $nodeTraverser = new \_PhpScopere8e811afab72\PhpParser\NodeTraverser();
        $callableNodeVisitor = $this->createNodeVisitor($callable);
        $nodeTraverser->addVisitor($callableNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    private function createNodeVisitor(callable $callable) : \_PhpScopere8e811afab72\PhpParser\NodeVisitor
    {
        return new class($callable) extends \_PhpScopere8e811afab72\PhpParser\NodeVisitorAbstract
        {
            /**
             * @var callable
             */
            private $callable;
            public function __construct(callable $callable)
            {
                $this->callable = $callable;
            }
            /**
             * @return int|Node|null
             */
            public function enterNode(\_PhpScopere8e811afab72\PhpParser\Node $node)
            {
                $callable = $this->callable;
                return $callable($node);
            }
        };
    }
}
