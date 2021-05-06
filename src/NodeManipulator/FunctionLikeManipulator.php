<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210506\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class FunctionLikeManipulator
{
    /**
     * @var \Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var \Rector\NodeNameResolver\NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\RectorPrefix20210506\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    /**
     * @return string[]
     */
    public function getReturnedLocalPropertyNames(\PhpParser\Node\FunctionLike $functionLike) : array
    {
        // process only class methods
        if ($functionLike instanceof \PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $returnedLocalPropertyNames = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($functionLike, function (\PhpParser\Node $node) use(&$returnedLocalPropertyNames) {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr === null) {
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
