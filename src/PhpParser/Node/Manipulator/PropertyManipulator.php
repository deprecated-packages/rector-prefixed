<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\Doctrine\AbstractRector\DoctrineTrait;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer;
use _PhpScopere8e811afab72\Rector\SOLID\Guard\VariableToConstantGuard;
/**
 * "private $property"
 */
final class PropertyManipulator
{
    use DoctrineTrait;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator;
    /**
     * @var VariableToConstantGuard
     */
    private $variableToConstantGuard;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var ReadWritePropertyAnalyzer
     */
    private $readWritePropertyAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\AssignManipulator $assignManipulator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\SOLID\Guard\VariableToConstantGuard $variableToConstantGuard, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository, \_PhpScopere8e811afab72\Rector\ReadWrite\NodeAnalyzer\ReadWritePropertyAnalyzer $readWritePropertyAnalyzer)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->assignManipulator = $assignManipulator;
        $this->variableToConstantGuard = $variableToConstantGuard;
        $this->nodeRepository = $nodeRepository;
        $this->readWritePropertyAnalyzer = $readWritePropertyAnalyzer;
    }
    /**
     * @return PropertyFetch[]|StaticPropertyFetch[]
     */
    public function getPrivatePropertyFetches(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : array
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return [];
        }
        $nodesToSearch = $this->nodeRepository->findUsedTraitsInClass($classLike);
        $nodesToSearch[] = $classLike;
        $singleProperty = $property->props[0];
        /** @var PropertyFetch[]|StaticPropertyFetch[] $propertyFetches */
        $propertyFetches = $this->betterNodeFinder->find($nodesToSearch, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($singleProperty, $nodesToSearch) : bool {
            // property + static fetch
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
                return \false;
            }
            // itself
            if ($this->betterStandardPrinter->areNodesEqual($node, $singleProperty)) {
                return \false;
            }
            // is it the name match?
            if (!$this->nodeNameResolver->areNamesEqual($node, $singleProperty)) {
                return \false;
            }
            return \in_array($node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE), $nodesToSearch, \true);
        });
        return $propertyFetches;
    }
    public function isPropertyUsedInReadContext(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($this->isDoctrineProperty($property)) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo !== null && $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\JMS\SerializerTypeTagValueNode::class)) {
            return \true;
        }
        $privatePropertyFetches = $this->getPrivatePropertyFetches($property);
        foreach ($privatePropertyFetches as $propertyFetch) {
            if ($this->readWritePropertyAnalyzer->isRead($propertyFetch)) {
                return \true;
            }
        }
        // has classLike $this->$variable call?
        /** @var ClassLike $classLike */
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        return (bool) $this->betterNodeFinder->findFirst($classLike->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
                return \false;
            }
            if (!$this->readWritePropertyAnalyzer->isRead($node)) {
                return \false;
            }
            return $node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr;
        });
    }
    public function isPropertyChangeable(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        $propertyFetches = $this->getPrivatePropertyFetches($property);
        foreach ($propertyFetches as $propertyFetch) {
            if ($this->isChangeableContext($propertyFetch)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param PropertyFetch|StaticPropertyFetch $node
     */
    private function isChangeableContext(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $parent = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreInc || $parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PreDec || $parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostInc || $parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PostDec) {
            $parent = $parent->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            $readArg = $this->variableToConstantGuard->isReadArg($parent);
            if (!$readArg) {
                return \true;
            }
        }
        return $this->assignManipulator->isLeftPartOfAssign($node);
    }
}
