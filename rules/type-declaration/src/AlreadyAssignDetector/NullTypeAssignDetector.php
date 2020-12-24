<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ScopeNestingComparator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
/**
 * Should add extra null type
 */
final class NullTypeAssignDetector extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\AlreadyAssignDetector\AbstractAssignDetector
{
    /**
     * @var ScopeNestingComparator
     */
    private $scopeNestingComparator;
    /**
     * @var DoctrineTypeAnalyzer
     */
    private $doctrineTypeAnalyzer;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator, \_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function detect(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : ?bool
    {
        $needsNullType = null;
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($propertyName, &$needsNullType) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            if ($this->scopeNestingComparator->isNodeConditionallyScoped($expr)) {
                $needsNullType = \true;
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            // not in doctrine property
            $staticType = $this->nodeTypeResolver->getStaticType($expr);
            if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($staticType)) {
                $needsNullType = \false;
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            return null;
        });
        return $needsNullType;
    }
}
