<?php

declare (strict_types=1);
namespace Rector\Naming\PropertyRenamer;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\VarLikeIdentifier;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\NodeNameResolver\NodeNameResolver;
final class PropertyFetchRenamer
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function renamePropertyFetchesInClass(\PhpParser\Node\Stmt\ClassLike $classLike, string $currentName, string $expectedName) : void
    {
        // 1. replace property fetch rename in whole class
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike, function (\PhpParser\Node $node) use($currentName, $expectedName) : ?Node {
            if ($this->nodeNameResolver->isLocalPropertyFetchNamed($node, $currentName) && $node instanceof \PhpParser\Node\Expr\PropertyFetch) {
                $node->name = new \PhpParser\Node\Identifier($expectedName);
                return $node;
            }
            if ($this->nodeNameResolver->isLocalStaticPropertyFetchNamed($node, $currentName)) {
                if (!$node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
                    return null;
                }
                $node->name = new \PhpParser\Node\VarLikeIdentifier($expectedName);
                return $node;
            }
            return null;
        });
    }
}
