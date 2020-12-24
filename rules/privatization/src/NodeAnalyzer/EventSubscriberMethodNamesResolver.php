<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Privatization\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
final class EventSubscriberMethodNamesResolver
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveFromClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$methodNames) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            if (!$node->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $methodNames[] = $node->value->value;
        });
        return $methodNames;
    }
}
