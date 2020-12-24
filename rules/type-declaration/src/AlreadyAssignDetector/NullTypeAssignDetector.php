<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\NodeNestingScope\ScopeNestingComparator;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer;
/**
 * Should add extra null type
 */
final class NullTypeAssignDetector extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\AbstractAssignDetector
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNestingScope\ScopeNestingComparator $scopeNestingComparator, \_PhpScoperb75b35f52b74\Rector\PHPStanStaticTypeMapper\DoctrineTypeAnalyzer $doctrineTypeAnalyzer, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->scopeNestingComparator = $scopeNestingComparator;
        $this->doctrineTypeAnalyzer = $doctrineTypeAnalyzer;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function detect(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : ?bool
    {
        $needsNullType = null;
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName, &$needsNullType) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            if ($this->scopeNestingComparator->isNodeConditionallyScoped($expr)) {
                $needsNullType = \true;
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            // not in doctrine property
            $staticType = $this->nodeTypeResolver->getStaticType($expr);
            if ($this->doctrineTypeAnalyzer->isDoctrineCollectionWithIterableUnionType($staticType)) {
                $needsNullType = \false;
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            return null;
        });
        return $needsNullType;
    }
}
