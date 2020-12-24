<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    /**
     * @return string[]
     */
    public function getReturnedLocalPropertyNames(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : array
    {
        // process only class methods
        if ($functionLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_) {
            return [];
        }
        $returnedLocalPropertyNames = [];
        $this->callableNodeTraverser->traverseNodesWithCallable($functionLike, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$returnedLocalPropertyNames) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_ || $node->expr === null) {
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
