<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    /**
     * @return string[]
     */
    public function getReturnedLocalPropertyNames(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : array
    {
        // process only class methods
        if ($functionLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $returnedLocalPropertyNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($functionLike, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$returnedLocalPropertyNames) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
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
