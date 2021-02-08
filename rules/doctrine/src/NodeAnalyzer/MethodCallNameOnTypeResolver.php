<?php

declare (strict_types=1);
namespace Rector\Doctrine\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
use RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class MethodCallNameOnTypeResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20210208\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @return string[]
     */
    public function resolve(\PhpParser\Node $node, string $type) : array
    {
        $methodNames = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($node, function (\PhpParser\Node $node) use(&$methodNames, $type) {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->nodeTypeResolver->isObjectType($node->var, $type)) {
                return null;
            }
            $name = $this->nodeNameResolver->getName($node->name);
            if ($name === null) {
                return null;
            }
            $methodNames[] = $name;
        });
        return \array_unique($methodNames);
    }
}
