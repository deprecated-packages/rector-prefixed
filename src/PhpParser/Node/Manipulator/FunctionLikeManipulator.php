<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
final class FunctionLikeManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a6b37af0871\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    /**
     * @return string[]
     */
    public function getReturnedLocalPropertyNames(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : array
    {
        // process only class methods
        if ($functionLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $returnedLocalPropertyNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($functionLike, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$returnedLocalPropertyNames) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
                return null;
            }
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node->expr)) {
                return null;
            }
            $propertyName = $this->nodeNameResolver->getName($node->expr);
            if ($propertyName === null) {
                return null;
            }
            $returnedLocalPropertyNames[] = $propertyName;
        });
        return $returnedLocalPropertyNames;
    }
}
