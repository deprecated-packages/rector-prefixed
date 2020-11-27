<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
final class EventSubscriberMethodNamesResolver
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveFromClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use(&$methodNames) {
            if (!$node instanceof \PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            if (!$node->value instanceof \PhpParser\Node\Scalar\String_) {
                return null;
            }
            $methodNames[] = $node->value->value;
        });
        return $methodNames;
    }
}
