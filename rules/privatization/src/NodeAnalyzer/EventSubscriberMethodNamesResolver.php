<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Privatization\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
final class EventSubscriberMethodNamesResolver
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveFromClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$methodNames) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            if (!$node->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $methodNames[] = $node->value->value;
        });
        return $methodNames;
    }
}
