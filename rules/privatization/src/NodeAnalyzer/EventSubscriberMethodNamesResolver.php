<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Privatization\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
final class EventSubscriberMethodNamesResolver
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @return string[]
     */
    public function resolveFromClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $methodNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$methodNames) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            if (!$node->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $methodNames[] = $node->value->value;
        });
        return $methodNames;
    }
}
